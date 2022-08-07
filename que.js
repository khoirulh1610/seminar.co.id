require('events').EventEmitter.defaultMaxListeners = 0
const EventEmitter = require('events');
const util = require('util');
const mysql = require('mysql');
const { default: axios } = require('axios');
const args = require('minimist')(process.argv.slice(2));
var server_id = args['s'] || 4;
var status = [];
var ant = [];
var con = mysql.createPool({
    connectionLimit: 500,
    host: '127.0.0.1',
    user: 'root',
    password: '@Admin@123!',
    database: 'seminar',
    charset: 'utf8mb4_general_ci'
});
const query = util.promisify(con.query).bind(con);

class Device {
    constructor(id) {
        this.id = id;
    }

    async get() {
        return await query(`SELECT a.id as token,a.status,a.user_id,b.ip,b.port,b.apikey FROM devices a left join servers b on a.server_id=b.id WHERE a.status='AUTHENTICATED' and server_id = ${this.id}`);
    }
}

class Kirim {
    constructor(data) {
        this.data = data;
    }
    AsynKirim() {
        console.log(this.data.token);
        let data = this.data;
        let token = this.data.token;
        let tb = `zu${data.user_id}_antrians`;
        con.query(`select * from ${tb} where device_id = '${token}' and status=1 limit 0,1`, (err, result) => {
            if (err) throw err;
            if (result.length > 0) {
                var row = result[0];
                
                var data_kirim = {
                    "token": String(row.device_id),
                    "id": row.id,
                    "phone": row.phone,
                    "message": TimeReplace(row.message),
                    "file_url": row.file,
                    "file_name": row.file_name
                };

                if (row.type_message === "Button") {
                    data_kirim.type = "Button";
                    data_kirim.payload = this.formatButton(row);
                }

                console.log(data_kirim);
                
                var options = {
                    method: 'POST',
                    url: `http://${data.ip}:${data.port}/api/send`,
                    headers: { 'Content-Type': 'application/json', 'apikey': data.apikey },
                    data: data_kirim
                };

                axios.request(options).then(async function(response) {
                    let message = response.data?.message || "";
                    let msgid = response?.data?.data?.messageid || "";
                    // console.log(`${data.token} - ${message} - ${msgid}`);
                    if (message == 'device offline') {
                        await query(`update devices set status='NOT AUTHENTICATED' where id=${token}`);
                        con.query(`update ${tb} set status=1 where id=${row.id}`);
                        ant[token] = undefined;
                    } else if (message == 'Terkirim') {
                        await query(`update ${tb} set status=2,report='${message}',messageid='${msgid}' where id=${row.id}`);
                    } else {
                        await query(`update ${tb} set status=3,report='${message}' where id=${row.id}`);
                    }
                    if (ant[token]) ant[token].Next(row.pause * 1000);
                }).catch(function(error) {
                    console.log(error);
                })


            } else {
                setTimeout(() => {
                    if (ant[token]) ant[token].AsynKirim();
                }, 1000 * 30);
            }
        })
    }

    /**
     * Handle Formating Payload Button
     */
    formatButton(dataPesan) {
        let payload = [];
        function addPayload(text, id) {
            var r = payload.push({
                buttonId: id,
                buttonText: {displayText: text}
            })
        }
        if (!isNull(dataPesan.btn1)) {
        addPayload(dataPesan.btn1, `${dataPesan.id}<|>1<|>${dataPesan.reply1}`)
        }
        if (!isNull(dataPesan.btn2)) {
        addPayload(dataPesan.btn2, `${dataPesan.id}<|>2<|>${dataPesan.reply2}`)
        }
        if (!isNull(dataPesan.btn3)) {
        addPayload(dataPesan.btn3, `${dataPesan.id}<|>3<|>${dataPesan.reply3}`)
        }
        return payload
    }

    
    Next(delay) {
        setTimeout(this.AsynKirim(), delay);
    }
}


async function getDevice() {
    var device = new Device(server_id);
    var data = await device.get();
    // console.log(data);
    for (var i = 0; i < data.length; i++) {
        let row = data[i];
        let token = row.token
        if (!ant[token]) {
            ant[token] = new Kirim(row);
            ant[token].AsynKirim();
        }
    }
}

function TimeReplace(mystr) {
    let Jam = new Date().getHours();
    let Hasil = "";
    if (Jam >= 0 && Jam < 10) {
        Hasil = "Pagi";
    } else if (Jam >= 10 && Jam < 15) {
        Hasil = "Siang";
    } else if (Jam >= 15 && Jam <= 17) {
        Hasil = "Sore";
    } else {
        Hasil = "Malam";
    }
    return mystr.replace(/Malam|Sore|Siang|Pagi/g, Hasil);
}


(async() => {
    getDevice();
    setInterval(() => {
        getDevice();
    }, 5000);
})();


function isNull(data) {
	return (
	  (data === '') || 
	  (data === null) ||
	  (data === 0)
	);
}