require('dotenv').config({
    path: __dirname + '/../.env'
})
const express = require("express");
const bodyParser = require("body-parser");
const axios = require("axios");
const args = require("minimist")(process.argv.slice(2));
const portApp = args["p"] || 3000;
const app = express();
const { Sequelize, DataTypes, QueryTypes } = require("sequelize");
const sequelize = new Sequelize(env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'), {
    host: env('DB_HOST'),
    logging: false,
    dialect: env('DB_CONNECTION'),
    pool: {
        max: 5,
        min: 0,
        idle: 10000
    }
});
let processID = 1;

// get value env
function env(key) {
    return process.env[key];
}

// Custom Logging
class Logging {
    #mode = "dev"; // dev|prod
    constructor({ mode = "dev" }) {
        this.#mode = mode;
    }
    log(...data) {
        if (this.#mode == "prod") return false;
        console.log(...data);
    }
}
// create Logging
const logging = new Logging({ mode: "prod" });
const logBtn = new Logging({ mode: "prod" });

// support parsing of application/json type post data
app.use(bodyParser.json());
//support parsing of application/x-www-form-urlencoded post data
app.use(bodyParser.urlencoded({ extended: true }));

app.get("/", function (req, res) {
    res.send("Hello World!");
});

app.all("/callback", async function (req, res) {
    var PID = `[${processID}]`;
    processID = processID >= 100 ? 1 : processID + 1;

    logging.log(`-> ${PID} callback received`);
    res.send("OK");

    const data = req.body;
    const device_id = data.token ?? false;
    const callback = {};
    // handle request with missing data
    try {
        callback.fromMe = data.fromMe ? "Y" : "N";
        callback.type = data.type ?? null;
        callback.message = data.message ?? null;
        callback.message = callback.message
            ? callback.message.replace("'", "''")
            : null;
        callback.phone = data.phone ?? null;
    } catch (error) {
        logging.log(" !", PID, "Callback data missing");
        return false;
    }

    if (callback.fromMe == "N") {
        let label = "<-";
        // Filter callback type Yang boleh lanjut
        if (
            // callback.type == "conversation" ||
            // callback.type == "chat" ||
            callback.type == "messageContextInfo" ||
            callback.type == "button"
        ) {
            label = " >";
            logging.log(label, PID, 'device:', device_id, callback.type);
        } else {
            logging.log(label, PID, 'device:', device_id, callback.type, 'SKIP!!!');
            return false;
        }
    }
    // Jika callback dari server sendiri maka skip
    else {
        logging.log("<-", PID, "from me skip");
        return false;
    }

    let device = await runQuery(
        `select * from devices where id=${device_id} limit 0,1`
    );
    if (device.length == 0) {
        var msg = `device ${device_id} not found`;
        logging.log(" !", PID, msg);
        return false;
    }
    device = device[0];
    logging.log(" >", PID, "device:", device.id, "server:", device.server_id);

    const user_id = device.user_id;
    const tableNameAntrian = `zu${user_id}_antrians`;
    const tableNameAutoreply = `zu${user_id}_autoreplies`;
    const tableNameContact = `zu${user_id}_contacts`;
    const tableNameRespons = `zu${user_id}_respons`;

    // jika pesan-nya text dan dari lawan bicara, maka balas pesan-nya
    // if ((callback.type == "conversation" || callback.type == "chat") && callback.fromMe == "N") {
    //     // Jika pesan terlalu panjang maka skip
    //     if (callback.message.length > 60) {
    //         logging.log(
    //             "<-",
    //             PID,
    //             "Tidak dibalas melebihi 60 karakter"
    //         );
    //         return false;
    //     }

    //     // Periksa apakah ada autoreply yang cocok
    //     let autoreply = await runQuery({
    //         query: `select * from ${tableNameAutoreply} where device_id=${device_id} and cmd=? limit 0,1`,
    //         values: [callback.message]
    //     });
    //     // let autoreply = await runQuery(`select * from ${tableNameAutoreply} where device_id=${device_id} and cmd='${callback.message}' limit 0,1`);
    //     if (autoreply.length == 0) {
    //         var msg = `autoreply not found`;
    //         logging.log(" <", PID, msg);
    //         return false;
    //     }
    //     autoreply = autoreply[0];

    //     let contact = await runQuery(
    //         `select * from ${tableNameContact} where phone='${callback.phone}' limit 0,1`
    //     );
    //     contact = contact[0];

    //     const textMsg = contact
    //         ? replaceTextByData(autoreply.reply, contact)
    //         : autoreply.reply;
    //     const payloadSendMsg = {
    //         token: device.id,
    //         phone: callback.phone,
    //         message: textMsg,
    //         file_url: autoreply.url
    //     };
    //     const res = await sendMsgToAPIWA(device.server_id, payloadSendMsg, PID);

    //     try {
    //         const antrian = runQuery(
    //             `insert into ${tableNameAntrian} (phone, user_id, device_id, device_phone, message, file, type, status, report, pause, sent_at, created_at, att1) values ('${callback.phone
    //             }', ${user_id}, ${device_id}, '${device.phone
    //             }', '${textMsg}', '${autoreply.url}', 'Text', ${res?.status ? 2 : 3
    //             }, '${res?.message ?? null}', 0, NOW(), NOW(), 'Auto Reply')`,
    //             QueryTypes.INSERT
    //         );
    //     } catch (error) {
    //         logging.log(" ! Save msg to DB", PID, error.message);
    //     }
    //     logging.log("<-", PID, "autoreply finished");
    // }
    // Button Message
    // else 
    if (callback.type == "messageContextInfo" || callback.type == "button") {
        const btnid = data.selectedButtonId;
        const btnText = data.selectedDisplayText;
        handleResponButton(
            btnid,
            btnText,
            data,
            tableNameAntrian,
            device.server_id,
            PID
        );
    }

    return true;
});

app.listen(portApp, "0.0.0.0", function () {
    console.log(`http://127.0.0.1:${portApp}`);
});

async function handleResponButton(
    btnId,
    btnText,
    data,
    tableNameAntrian,
    server_id,
    PID
) {
    const param = btnId.split("<|>");
    try {
        var id_pesan = param[0];
        var nomor_btn = param[1];
        var response_text = param[2];
        var check_reply = 0; // disable chat replay
        var update = false; // disable update jawaban dulu
    } catch (error) {
        logBtn.error(
            " !",
            PID,
            "Button data missing (Format invalid)",
            error.message
        );
        return false;
    }

    if (check_reply == 1) {
        let antrian = await runQuery(
            `select * from ${tableNameAntrian} where id=${id_pesan} limit 0,1`
        );
        if (!antrian) {
            logBtn.log(
                " !",
                PID,
                `table: ${tableNameAntrian} id:${id_pesan} tidak ditemukan`
            );
            return;
        } else {
            antrian = antrian[0];
        }

        // Jika sudah pilih maka kirim pesan balasan dari coll next_reply
        if (
            !isNull(antrian.btn_select_text) ||
            !isNull(antrian.btn_select_id)
        ) {
            // Jika next_reply kosong GAK USAH DILANJUTKAN
            if (isNull(antrian.next_reply)) {
                return false;
            } else {
                response_text = antrian.next_reply;
            }

            // ubah ke false agar gak diupdate lagi jawannya
            update = false;
        }
    }

    // fiture belum ada di seminar
    if (update) { // nilai update menentukan apakah jawaban button akan diupdate atau tidak
        // save pilihan button ke database
        try {
            runQuery(
                `update ${tableNameAntrian} set btn_select_id=${nomor_btn}, status=2, btn_select_text='${btnText}' where id=${id_pesan}`,
                QueryTypes.UPDATE
            );
        } catch (error) {
            console.error("btnid:", btnId);
        }
    }

    const data_pesan = {
        token: data.token,
        type: "text",
        phone: data.phone,
        message: response_text
    };
    const res = await sendMsgToAPIWA(server_id, data_pesan, PID);
    logBtn.log("<-", PID, "button reply finished");
    return res;
}

function isNull(data) {
    return data === "" || data === null || data === 0;
}

const runQuery = (query, qtype = QueryTypes.SELECT) => {
    return sequelize.query(query, { type: qtype });
};

const replaceTextByData = (text, data) => {
    let result = text;
    for (let key in data) {
        result = result.replace(`[${key}]`, data[key] ?? "");
    }
    return result;
};

// Jika data akan disave ke DB param save di isi user_id(string)
const sendMsgToAPIWA = async (server_id, payload, PID, save = false) => {
    const server = await runQuery(
        `select * from servers where id=${server_id} limit 0,1`
    );
    if (server.length == 0) {
        var msg = `server ${server_id} not found`;
        logging.log(" !", PID, msg);
        return false;
    }
    
    const data = {
        method: "POST",
        url: `http://${server[0].ip}:${server[0].port}/api/send`,
        headers: {
            "Content-Type": "application/json",
            apikey: server[0].apikey
        },
        data: payload
    };
    logging.log(" >", PID, `Send reply ${payload.phone}`);
    const response = await axios.request(data);
    logging.log(
        " >",
        PID,
        `------------ Response Send - ${payload.phone}:`,
        response?.data?.status,
        response?.data?.message
    );
    return response.data;
};
