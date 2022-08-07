(nodeMailer = require("nodemailer")), (bodyParser = require("body-parser"));

let transporter = nodeMailer.createTransport({
    host: "mail.seminar.biz.id",
    port: 465,
    secure: true,
    auth: {
        user: "info@seminar.biz.id",
        pass: "Admin123",
    },
    tls: {
        // do not fail on invalid certs
        rejectUnauthorized: false,
    },
});
let mailOptions = {
    from: "info@seminar.biz.id", // sender address
    to: "madeheri14@gmail.com", // list of receivers
    subject: "test pesan", // Subject line
    text: "isi pesan text", // plain text body
    html: "<b>NodeJS Email Tutorial</b>", // html body
};

transporter.sendMail(mailOptions, (error, info) => {
    if (error) return console.log(error);
    console.log("Message %s sent: %s", info.messageId, info.response);
});
