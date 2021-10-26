// Pengaturan
require('dotenv').config({path:'../.env'});
const port = process.env.APP_WA_PORT;
const browsername = "SEMINAR.CO.ID";
const deviceUrl = "";
const apiurl = "http://localhost:"+port;
const WEBHOOK = "";
const webserver = "";
const defaultDeviceID = 0;

// ------------------//
var mysql = require('mysql');
var con  = mysql.createPool({
  // connectionLimit : 500,
  host            : process.env.DB_HOST,
  user            : process.env.DB_USERNAME,
  password        : process.env.DB_PASSWORD,
  database        : process.env.DB_DATABASE,
  port            : process.env.DB_PORT,
  charset         : 'utf8mb4_general_ci'
});
con.query('SELECT 1 + 1 AS solution', function (error, results, fields) {  
  if (error) return console.error(error);
  console.log('Cek Koneksi : ', results[0].solution>0 ? 'Online' : 'Offline');
});
// end pengaturan

const qrcodeT = require("qrcode-terminal");
const qrcode = require('qrcode');
const moment = require("moment");
const get = require('got')
const fs = require("fs");
const { ToWa,ToPhone,decodeEntities,TimeReplace } = require('./lib.js');
const axios = require("axios");
const imageToBase64 = require('image-to-base64');
const mime = require('mime-types');
const url = require("url");
const path = require("path");
var EventEmitter = require('events');
const express = require('express');
const bodyParser = require("body-parser");
const app = express();
class MyEmitter extends EventEmitter {};
const { WAConnection,MessageType,Presence,MessageOptions,Mimetype,WALocationMessage,WA_MESSAGE_STUB_TYPES,ReconnectMode,ProxyAgent,waChatKey,Browsers} = require('@adiwajshing/baileys');


let batteryLevelStr = [];
let batterylevel = [];
let mynumber = [];
let qrke = [];
const antrian=[];
const conn = [];
const authInfo = [];
const PicProfile = [];

app.set('etag', false);

app.use((req, res, next) => {
  res.set('Cache-Control', 'no-store')
  next()
})

app.use(function(req, res, next) {
  //delete all headers related to cache
  req.headers['if-none-match'] = '';
  req.headers['if-modified-since'] = '';
  next();    
});

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(express.static('public'));

app.get('/', (req, res) => res.sendFile(path.normalize(__dirname + '/views/index.html')));
let QR = [];
function foreach(arr, func)
{
   for (var i in arr)
   {
      func(i, arr[i]);
   }
}

function makeid(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQR[number]STUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

let id_device;
let url_webhook;
let devices = [];
let no_device;
let isbc;

let dataRemoved;
let datanew;
var setValue = [];
let iscron = [];

isbc = "no";

app.post('/new', express.json(), async (req, res) => {
  const { webhook } = req.body
  id_device = req.body.instance.toString()
  no_device = getNo(); // req.body.instance
  isbc = req.body.bc || 'no'
  if(!conn[id_device]){
    newinstance(id_device,no_device)
    res.status(200).json({ "status":true, type: 'new', instance: id_device, webhook })
  }else{
    if (conn[id_device].phoneConnected) {
      log = {"status": true, "instance": id_device, "qrcode": "", "message": "AUTHENTICATED"}
      res.json(log);
    } else {
        if(QR[id_device]!=''){
          const ress = await qrcode.toDataURL(QR[id_device]);
          log = {"status": true, "instance": id_device, "qrcode": ress, "message": "Ready to Scan"}
          console.log(log);
          res.json(log);
        }else{
          conn[id_device].clearAuthInfo();        
          QR[id_device] = null;        
          conn[id_device] = null;          
          // conn[id_device].connect();
          newinstance(id_device,no_device);
          log = {"status": true, "instance": id_device, "qrcode": "", "message": "ON CONNECTING"}
          console.log(log);
          res.json(log);
        }
    }    
    // res.status(201).json({ "status":false,"message":id_device + " Device sudah ada!"})
  }
  
})


const newinstance = async (number, no) => {  
  con.query("update devices set status='NOT READY',qrcode=null where id="+number);
  conn[number] = new WAConnection()
  conn[number].connectOptions = {
    maxIdleTimeMs: 60_000,
    // maxRetries: Infinity,
    maxRetries: 4,
    connectCooldownMs: 4_000,
    phoneResponseTime: 15_000,
    alwaysUseTakeover: true,
    logQR: false,
  }
  
  QR[number] = "";
  iscron[number] = "no";

  conn[number].autoReconnect = ReconnectMode.onAllErrors; // ReconnectMode.onConnectionLost; // only automatically reconnect when the connection breaks
  conn[number].browserDescription = [ browsername + ' [' + number+']', 'chrome', '10' ];
  //conn[number].logger.level = 'warn';

  conn[number].on('close', json =>
  {
    QR[number] = null;
    con.query("update devices set status='NOT READY' where id="+number);
    
    // if(conn[number]){
      //console.log(`[ ${moment().format("HH:mm:ss")} ] => Hapus session`);
      if(conn[defaultDeviceID]!==undefined){
        if(number != defaultDeviceID && conn[defaultDeviceID].phoneConnected) {
            conn[defaultDeviceID].sendMessage(mynumber[number], "Anda telah terputus dengan " + browsername + ".\nReason: *" + json.reason + "*" ,MessageType.text);
        }
      }
      
      // console.log(json);
      if(json.reason == "invalid_session") {
        deleteSession(`./auth_info/${number}.json`);        
        conn[number].clearAuthInfo();
        QR[number] = null;
        conn[number].connect();
      }
    // }
    
    if(antrian[number]){
      antrian[number] = undefined;
    }
    
  })

  conn[number].on('ws-close',json=>{    
    console.log('ws-close : ' + number,json);
  });

  conn[number].on('connection-phone-change',state=>{    
    if(state.connected==false){
      QR[number] = null;
      con.query("update devices set status='NOT READY',qrcode=null where id="+number);
    }    
    console.log('connection-phone-change : ' + number,state);
  });

  conn[number].on('open', async (json) =>
  {
    authInfo[number] = conn[number].base64EncodedAuthInfo()
    fs.writeFileSync(`./auth_info/${number}.json`, JSON.stringify(authInfo[number], null, '\t')) // save this info to a file
    fs.writeFileSync(`./device_info/${number}.json`, JSON.stringify(json, null, '\t')) // save this info to a file

    QR[number] = "AUTHENTICATED";   
    mynumber[number] = json.user.jid;    
    try {
      PicProfile[number] = await conn[number].getProfilePicture(json.user.jid);  
    } catch (error) {
      PicProfile[number] = '';
    }
    let qry_open = "update devices set status='AUTHENTICATED',nama='"+(json.user.name || null )+"',qrcode=null,phone='"+ToPhone(mynumber[number])+"',profile_url='"+PicProfile[number]+"' where id="+number;    
    con.query(qry_open);
    if(!antrian[number]){
      newAntrian(number);
    }
  });

  log = "";
  conn[number].on('qr',async(qr) =>
  {    
    QR[number] = qr;
    const ress = await qrcode.toDataURL(qr);
    // qrcodeT.generate(qr,{small: true});    
    con.query("update devices set qrcode='"+ress+"',status='Start' where id="+number);        
  });
  

  fs.existsSync(`./auth_info/${number}.json`) && conn[number].loadAuthInfo(`./auth_info/${number}.json`)
  conn[number].connect().catch(err=>{
    console.log('Koneksinya error Bro: '+number,err);
  });

  conn[number].on('CB:action,,battery', json => {
        batteryLevelStr[number] = json[2][0][1].value
        batterylevel[number] = parseInt(batteryLevelStr[number])
        console.log('battery level: ' + batterylevel[number])
        con.query("update devices set battery="+batterylevel[number]+" where id="+number);    
  })
  conn[number].on('contacts-received',data=>{
    fs.writeFileSync(`./device_info/contacts_${number}.json`, JSON.stringify(data, null, '\t')) // save this info to a file
    let contacts = data.updatedContacts
    con.query("select * from devices where id="+number,function(error,rows,f){
      if(error) console.log(error);
      for (let i = 0; i < rows.length; i++) {
        const device = rows[i];
        let contact_device = "wacontacts";
        let user_id = device.user_id;
        con.query("delete from "+contact_device+" where device_id="+number,function (err, result){
          if(err) console.log(err);
          contacts.forEach(r => {          
            if(r.name){              
              let sql = "insert into "+contact_device+"(user_id,device_id,phone,name)values("+user_id+","+number+",'"+ToPhone(r.jid)+"','"+r.name+"')";
              // console.log(sql);
              con.query(sql);
            }          
          });
        });    
      }
    });
    
  });
  conn[number].on('chat-update', async(chat) =>
  {
    
    if (chat.messages!==undefined) {
      const m = chat.messages.all()[0] // pull the new message from the update      
    //  if(fromme == false){
        if(m.key.remoteJid.match(/status/g) != "status"){
          con.query("update devices set status='AUTHENTICATED' where id="+number);
          QR[number] = 'AUTHENTICATED';
          if(!antrian[number]){
            newAntrian(number);
          }
          const messageContent = m.message
          if(messageContent!==null){
            console.log('Data Pesan :',messageContent);
          let text = '';     
          let id = m.key.remoteJid
          const messageType = Object.keys(messageContent)[0] // message will always contain one key signifying what kind of message
          let imageMessage = m.message.imageMessage;
          let typeMsg = '';
          var rndfile = makeid(20);
          let fromme = m.key.fromMe
      
          if(m.message.conversation){
            text = m.message.conversation;
          }
         var ppUrl = ''; // leave empty to get your own
          try{
            ppUrl = await conn[number].getProfilePicture (m.key.remoteJid); // leave empty to get your own
          }catch(error){
            //console.log(error);
          }
    
             const pushname = conn[number].chats.get (m.key.remoteJid).name;
             let participantid = m.participant;
             let participantgroup;
             let participantname;
             
             if(participantid == 'undefined' || participantid == '' || participantid == undefined || participantgroup==undefined) {
                participantname = null;
                participantgroup = null;
             } else {        
                participantgroup = conn[number].chats.get(participantid);
                participantname = participantgroup.name;
             }
             
    
             if(m.message.imageMessage){
                typeMsg = "image";
                strtype = m.message.imageMessage.mimetype;
                strfilename = "files/" + number + "_" + rndfile;
                strfilepath = "files/" + number + "_" + rndfile + "." + strtype.split("/")[1];
                if(m.key.fromMe == false) {
                  const buffer = await conn[number].downloadMediaMessage(m) // to decrypt & use as a buffer       
                  const savedFilename = await conn[number].downloadAndSaveMediaMessage (m,path.normalize(__dirname + "/" + strfilename), true) // to decrypt & save to file 
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "number":m.key.remoteJid, "name": pushname,"message": m.message.imageMessage.caption,"file": webserver + "/" + strfilepath, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"mimetype": m.message.imageMessage.mimetype,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.documentMessage){
                typeMsg = "document";
                filedoc = m.message.documentMessage.fileName;
                strfilename = "files/" + number + "_" + filedoc.split(".")[0] + "-" + rndfile + "." + filedoc.split(".")[1];     
                strfilepath = "files/" + number + "_" + filedoc.split(".")[0] + "-" + rndfile + "." + filedoc.split(".")[1];    
                if(m.key.fromMe == false) {
                  const buffer = await conn[number].downloadMediaMessage(m) // to decrypt & use as a buffer       
                  const savedFilename = await conn[number].downloadAndSaveMediaMessage (m,path.normalize(__dirname + "/" + strfilename), false) // to decrypt & save to file  
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "number":m.key.remoteJid, "name": pushname,"message": m.message.documentMessage.title,"file": webserver + "/" + strfilepath,"filename": m.message.documentMessage.fileName, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"mimetype": m.message.documentMessage.mimetype,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.stickerMessage){
                typeMsg = "sticker";
                strtype = m.message.stickerMessage.mimetype;
                strfilename = "files/" + number + "_" + rndfile;
                strfilepath = "files/" + number + "_" + rndfile + "." + strtype.split("/")[1];
                strname = number + "_" + rndfile + "." + strtype.split("/")[1];
                if(m.key.fromMe == false) {
                  const buffer = await conn[number].downloadMediaMessage(m) // to decrypt & use as a buffer       
                  const savedFilename = await conn[number].downloadAndSaveMediaMessage (m,path.normalize(__dirname + "/" + strfilename), true) // to decrypt & save to file      
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "number":m.key.remoteJid, "name": pushname,"message": webserver + "/" + strfilepath,"file": strname,"isAnimated": m.message.stickerMessage.isAnimated, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"mimetype": m.message.stickerMessage.mimetype,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.videoMessage){
                typeMsg = "video";
                strtype = m.message.videoMessage.mimetype;
                strfilename = "files/" + number + "_" + rndfile;
                strfilepath = "files/" + number + "_" + rndfile + "." + strtype.split("/")[1];
                strname = number + "_" + rndfile + "." + strtype.split("/")[1];
                if(m.key.fromMe == false) {
                  const buffer = await conn[number].downloadMediaMessage(m) // to decrypt & use as a buffer       
                  const savedFilename = await conn[number].downloadAndSaveMediaMessage (m,path.normalize(__dirname + "/" + strfilename), true) // to decrypt & save to file     
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "number":m.key.remoteJid, "name": pushname, "message": webserver + "/" + strfilepath, "file": strname,"ptt": m.message.videoMessage.ptt,"seconds": m.message.videoMessage.seconds, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"mimetype": m.message.videoMessage.mimetype,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.audioMessage){
                typeMsg = "audio";
                strtype = m.message.audioMessage.mimetype;
                strtype = strtype.split(";")[0];
                strfilename = "files/" + number + "_" + rndfile;
                strfilepath = "files/" + number + "_" + rndfile + "." + strtype.split("/")[1];
                strname = number + "_" + rndfile + "." + strtype.split("/")[1];
                if(m.key.fromMe == false) {
                  const buffer = await conn[number].downloadMediaMessage(m) // to decrypt & use as a buffer       
                  const savedFilename = await conn[number].downloadAndSaveMediaMessage (m,path.normalize(__dirname + "/" + strfilename), true) // to decrypt & save to file     
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "phone":ToPhone(m.key.remoteJid), "name": pushname, "message": webserver + "/" + strfilepath, "file": strname, "ptt": m.message.audioMessage.ptt,"seconds": m.message.audioMessage.seconds, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"mimetype": m.message.audioMessage.mimetype,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.locationMessage){
                typeMsg = "location";
                //strtype = m.message.locationMessage.mimetype;
                strfilename = "files/" + number + "_loc-" + rndfile;
                strfilepath = "files/" + number + "_loc-" + rndfile + "..jpeg";
                if(m.key.fromMe == false) {
                  const buffer = await conn[number].downloadMediaMessage(m) // to decrypt & use as a buffer       
                  const savedFilename = await conn[number].downloadAndSaveMediaMessage (m,path.normalize(__dirname + "/" + strfilename), true) // to decrypt & save to file 
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "phone":ToPhone(m.key.remoteJid), "name": pushname, "message": webserver + "/" + strfilepath, "latitude": m.message.locationMessage.degreesLatitude,"longitude": m.message.locationMessage.degreesLongitude, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.extendedTextMessage){
                typeMsg = "extendedtext";
                if(m.key.fromMe == false) {
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "phone":ToPhone(m.key.remoteJid), "name": pushname,"message": m.message.extendedTextMessage.text, "quoteMsg": m.message.extendedTextMessage.contextInfo, "matchedText": m.message.extendedTextMessage.matchedText,"title": m.message.extendedTextMessage.title, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.liveLocationMessage){
                typeMsg = "livelocation";
                if(m.key.fromMe == false) {
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "phone":ToPhone(m.key.remoteJid), "name": pushname,"message":"", "duration":m.duration, "timeOffset":m.timeOffset,"latitude": m.message.liveLocationMessage.degreesLatitude,"longitude": m.message.liveLocationMessage.degreesLongitude,"finalLatitude": m.finalLiveLocation.degreesLatitude,"finalLongitude": m.finalLiveLocation.degreesLongitude, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else if(m.message.contactMessage){
                typeMsg = "contact";
                if(m.key.fromMe == false) {
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "phone":ToPhone(m.key.remoteJid), "name": pushname, "message":m.message.contactMessage.vcard, "caption":m.message.contactMessage.displayName, "displayName":m.message.contactMessage.displayName, "vcard":m.message.contactMessage.vcard, "profilePic": ppUrl,"participantNumber": m.participant, "participantName": participantname,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             } else {
                typeMsg = "text";
                if(m.key.fromMe == false) {
                  log = {"status": true, "report": false, "type":typeMsg,"server_phone":ToPhone(mynumber[number]), "id": m.key.id,"fromMe": m.key.fromMe, "phone":ToPhone(m.key.remoteJid), "name": pushname,"message": m.message.conversation, "profilePic": ppUrl, "participantNumber": m.participant, "participantName": participantname,"timestamp": m.messageTimestamp.low,"status": m.status, "instanceID": number};
                }
             }
    
             //log = {};
    
            //  if (WEBHOOK!=='' || WEBHOOK!==undefined || WEBHOOK.length>10){
            //           //console.log("Webhook",WEBHOOK);
            //           if(m.key.fromMe == false) {
            //             axios.post(WEBHOOK, log)
            //             .then((res) => {
            //               console.log('Resp webhook :',res.data);
            //             })
            //             .catch((error) => {
            //               console.error(error);
            //             })
            //           }
            //   }  
    
            //  console.log(`[ ${moment().format("HH:mm:ss")} ] => Nomor: [ ${id.split("@s.whatsapp.net")[0]} ] => ${text}`);
             console.log('log webhook',log); 
             //console.log(m);      
             // Groups
          }
          
          }
    
        // } else {
        //     if(m.key.remoteJid.match(/status/g) != "status"){
        //       console.log('Isi',messageContent.extendedTextMessage);
        //       let textmsg = "";
        //       if(!messageContent.extendedTextMessage==null){
        //         textmsg = messageContent.extendedTextMessage.text || '';                
        //       }else{
        //         textmsg = messageContent.conversation || '';                
        //       }                            
        //       log = {"status": true, "report":true,"fromMe":fromme, "id": m.key.id,"server_phone":ToPhone(mynumber[number]), "phone":ToPhone(m.key.remoteJid),"message": textmsg,"file":'',"participant": m.participant,"timestamp": m.messageTimestamp.low,"status": m.status == 0 ? "pending" : m.status == 2 ? "sent" : m.status == 3 ? "delivered" : "viewed", "idstatus": m.status, "instanceID": number};
        //       console.log(log); 
                
        //         if (WEBHOOK!=='' || WEBHOOK!==undefined || WEBHOOK.length>10){
        //                 // console.log("Webhook",WEBHOOK);
        //                 // axios.post(WEBHOOK, log)
        //                 // .then((res) => {
        //                 //  console.log(res.data);
        //                 // })
        //                 // .catch((error) => {
        //                 //   console.error(error);
        //                 // })
        //             }  
                
        //     }
        // }
    }
     
  })

  app.get("/getcontacts", async (req, res) => {      
    try {
      var token = req.body.instance || req.query.instance;
      if(conn[token]){
        let contacts = await conn[token].contacts;
          res.status(200).json({
              "status": true,
              "instance" : token,
              "msg": "Import kontak dari Hanphone",
              "data": contacts
            });
      }else{
        log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"};
        res.send(log);
      }
    } catch (error) {
      log = {"status": false, "instance": token, "message": error};
      res.send(log);
    }
  });

  app.get("/getchats", async (req, res) => {  
    // var token = req.body.instance;
    // if (QR[token]=='AUTHENTICATED'){
    //     const chats = await conn[token].chats; // load the next 25 chats
    //     res.status(200).json({
    //         "status": true,
    //         "msg": "chats "+chats.length,
    //         "data": chats
    //     });
    // }else{
    //   log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"}
    //   res.send(log);
    // }
    try {
      var token = req.body.instance || req.query.instance;
      if(conn[token]){
        let chats = await conn[token].chats;
          res.status(200).json({
              "status": true,
              "instance" : token,
              "msg": "Import kontak dari Hanphone",
              "data": chats
            });
      }else{
        log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"};
        res.send(log);
      }
    } catch (error) {
      log = {"status": false, "instance": token, "message": error};
      res.send(log);
    }

  });

  app.get("/getunreadchats", async (req, res) => {  
    var token = req.body.instance;
    if (QR[token]=='AUTHENTICATED'){
      const unread = await conn[token].loadAllUnreadMessages ()
        res.status(200).json({
            "status": true,
            "msg": "count "+ unread.length,
            "data": unread
        });
    }else{
      log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"}
      res.send(log);
    }
  });

  app.get("/group-info", async (req, res) => {  
    var token = req.body.instance;
    var gid = req.body.gid;
    if (QR[token]=='AUTHENTICATED'){
      const metadata = await conn[token].groupMetadata (gid) 
        res.status(200).json({
            "status": true,
            "msg": "Met Group",
            "data": metadata
        });
    }else{
      log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"}
      res.send(log);
    }
  });

  app.post("/groupCreate", async (req, res) => {  
    var token = req.body.instance;
    var gname = req.body.gname;
    var guser = req.body.guser;
    if (QR[token]=='AUTHENTICATED'){
      const group = await conn[token].groupCreate (gname, [guser])
        res.status(200).json({
            "status": true,
            "msg": "Group id : " + group.gid,
            "data": group
        });
    }else{
      log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"}
      res.send(log);
    }
  });

  app.post("/groupAdd", async (req, res) => {  
    var token = req.body.instance;
    var gid = req.body.gid;
    var guser = req.body.guser;
    if (QR[token]=='AUTHENTICATED'){
      const group = await conn[token].groupAdd (gid, [guser])
        res.status(200).json({
            "status": true,
            "msg": "User add to group "+guser,
            "data": group
        });
    }else{
      log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"}
      res.send(log);
    }
  });

  app.get('/logout', async (req, res) => {
    var token = req.body.instance;
    if(conn[token]) {
      if(QR[token]=="AUTHENTICATED") {
        deleteSession(`./auth_info/${token}.json`);
        //deleteSession(`./auth_info/${token}.config5.json`);
        conn[token].clearAuthInfo();
        QR[token] = null;
        //conn[token].connect();
        conn[token].close();
        conn[token].connect();
        log = {"status": true, "instance": token, "message": "Sukses logout!"}
        res.send(log);
      } else if(QR[token]!="AUTHENTICATED") {
        log = {"status": false, "instance": token, "message": "Status DISCONNECTED!"}
        res.send(log);
      }
    } else {
        log = {"status": false, "message": token + " Instance salah!"}
        res.send(log);
    }
  })

  app.get('/close', async (req, res) => {
    var token = req.body.instance;
    if(conn[token]) {
        conn[token].clearAuthInfo();
        QR[token] = null;
        conn[token].close()        
        log = {"status": true, "instance": token, "message": "Sukses close"}
        res.send(log);
    } else {
        log = {"status": false, "message": token + " Instance salah!"}
        res.send(log);
    }
  })

  

  app.get('/reset', async (req, res) => {
    var token = req.body.instance;
    if(conn[token]) {
        // conn[token].clearAuthInfo();
        QR[token] = null;
        conn[token].close()
        // conn[token] = null;
        conn[token].connect();
        log = {"status": true, "instance": token, "message": "Sukses reset"}
        res.send(log);
    } else {
        log = {"status": false, "message": token + " Instance salah!"}
        res.send(log);
    }
  })

  app.get('/qrcode', (req, res) => {
      var token = req.body.instance;
      
      //if (fs.existsSync(`./auth_info/${token}.json`) && conn[token].loadAuthInfo(`./auth_info/${token}.json`)) {
          if(conn[token]) {
            run().catch(error => console.error(error.stack));
    
            async function run() {
            const ress = await qrcode.toDataURL(QR[token]);
    
              if(typeof QR[token] !== 'undefined'){
                if (QR[token]!='AUTHENTICATED'){
                  log = {"status": true, "instance": token, "qrcode": ress, "message": "Ready scan now!"}
                  res.json(log);
                } else {
                    if (conn[token].phoneConnected) {
                        log = {"status": true, "instance": token, "qrcode": "", "message": "AUTHENTICATED"}
                        res.json(log);
                    } else {
                        log = {"status": true, "instance": token, "qrcode": "", "message": "ON CONNECTING"}
                        res.json(log);
                    }
                }
              } else {
                  log = {"status": false, "qrcode": null, "message": "Instance salah!"}
                  res.json(log);
              }
            }
          } else {
                  log = {"status": false, "qrcode": null, "message": "Instance salah!"}
                  res.json(log);
          }
      //} else {
                  //log = {"status": true, "instance": token, "qrcode": ress, "message": "Ready scan now!"}
                  //res.send(log);
      //}
  });

  app.post('/getprofilepic', async(req, res) => {
      var token = req.body.instance;
      var number = req.body.number;

      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if(conn[token]) {
            const exists = await conn[token].isOnWhatsApp (number)
            if (exists) {
              var getppUrl = ''; // leave empty to get your own
               try{
                  getppUrl = await conn[token].getProfilePicture (number); // leave empty to get your own
                  log = {"status": true, "number":number, "urlProfilepic":getppUrl};
               }catch(error){
                //console.log(error);
                log = {"status": false, "number":number, "urlProfilepic":null};
               } 
            } else {
                log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
            }     
                
          } else {
             log = {"status": false, "number":number, "message":"Instance salah!"};
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            //res.send(log);
        }
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"};
      } 
      res.send(log);
  });

  app.post('/checkNumber', async(req, res) => {
      var token = req.body.instance;
      var number = req.body.number;

      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if(conn[token]) {
            const exists = await conn[token].isOnWhatsApp (number)
            if (exists) {
                log = {"status": true, "number":number, "onWhatsApp":true};
            } else {
                log = {"status": true, "number":number, "onWhatsApp":false};
            }
          } else {
             log = {"status": false, "number":null, "message":"Instance salah!"};
          }
        } else {
          log = {"status": false, "number":null, "message":"Instance DISCONNECTED"};
        }
      } else {
          log = {"status": false, "number":null, "message":"Instance salah!"};
      }
      res.send(log);
  });

  app.post('/isConnected', async(req, res) => {
      var token = req.body.instance;
      //var number = req.body.number;
      if(conn[token]) {
        if (conn[token].phoneConnected) {
            log = {"status": true, "isConnected":true};
        } else {
            log = {"status": true, "isConnected":false};
        }
      } else {
         log = {"status": false, "message":"Instance salah!"};
      }
      res.send(log);
  });

  app.post('/isActivated', async(req, res) => {
      var token = req.body.instance;
      //var number = req.body.number;
      if(conn[token]) {
         log = {"status": true, "isActivated":true};       
      } else {
         log = {"status": true, "isActivated":false};
      }
      res.send(log);
  });

  app.post('/deviceInfo', async(req, res) => {
      var token = req.body.instance;

      if(conn[token]) {  
        if(conn[token].phoneConnected) {
          if(conn[token]) {  
             
             log = {"status": true, "id":conn[token].user.jid, "name":conn[token].user.name, "os_version":conn[token].user.phone.os_version, "manufacturer":conn[token].user.phone.device_manufacturer, "model":conn[token].user.phone.device_model, "batteryLevel": batterylevel[token]||0, "imgUrl":PicProfile[token], "isConnected": true, "isActivated": true, "message":"Sukses"};
           
          } else {
             log = {"status": false, "isActivated": false, "isConnected": false, "message":"Instance salah!","batteryLevel":0};
          }
        } else {
          log = {"status": false, "isActivated": true, "isConnected": false, "message":"Instance DISCONNECTED","batteryLevel":0};
        }
      } else {
          log = {"status": false, "isActivated": false, "isConnected": false, "message":"Instance salah!"};
      }
      res.send(log);
  });

  app.post('/batteryLevel', async(req, res) => {
      var token = req.body.instance;

      if(conn[token]) {      
        if(conn[token].phoneConnected) {
          if(conn[token]) {  
                if(batterylevel[token] == undefined) {              
                  log = {"status": false, "message":"Silahkan charger devicenya terlebih dahulu!"};
                } else {  
                  log = {"status": true, "batteryLevel":batterylevel[token], "message":"Sukses"};
                }
          } else {
             log = {"status": false, "batteryLevel":null, "message":"Instance salah!"};
          }
        } else {
          log = {"status": false, "batteryLevel":null, "message":"Instance DISCONNECTED"};
        }
      } else {
          log = {"status": false, "message":"Instance salah!"};
      }
      res.send(log);
  });

  app.post('/send-message', async(req, res) => {
      var number = req.body.number;
      var msg = req.body.message;
      var token = req.body.instance;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && msg && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {
                  conn[token].sendMessage(number, msg ,MessageType.text);
                  log = {"status": true, "number":number, "message":"Terkirim"};
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                }
                res.send(log);
              } else {
                  log = {"status": false, "number":null, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":null, "message":"Number, Message dan Token tidak boleh kosong"}
              res.send(log);
          } 
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        }
      } else {
                log = {"status": false, "number":null, "message":"Instance salah!"}
                console.log(log);
                res.send(log);
            } 

  });

  app.post('/send-broadcast', async(req, res) => {
      var number = req.body.number;
      var msg = req.body.message;
      var token = req.body.instance;
      var allnum = "";
      var allmsg = "";

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && msg && token){
              if(conn[token]) {

                // 20 second timeout
                var numbers = number.split(',');
                
                //await conn[token].connect ({timeoutMs: 30*1000});
                for(num in numbers){
                    num = numbers[num];
                    const exists = await conn[token].isOnWhatsApp (num)
                    if (exists) {
                      conn[token].sendMessage(num, msg ,MessageType.text);
                      if(num!=undefined || num!=null || num!="") {
                        allnum = allnum + "," + num;
                        allmsg = allmsg + "," + num + ":success";
                      }
                      //log = {"status": true, "number":num, "message":"Terkirim"};
                    } else {
                      if(num!=undefined || num!=null || num!="") {
                        allnum = allnum + "," + num;
                        allmsg = allmsg + "," + num + ":failed";
                      }
                      //log = {"status": false, "number":num, "message":"Belum_Terdaftar_Whatsapp"}
                    }                
              }
              log = {"status": true, "number":allnum.substring(1), "message":allmsg.substring(1)}
              res.send(log);

                
              } else {
                  log = {"status": false, "number":null, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":null, "message":"Number, Message dan Token tidak boleh kosong"}
              res.send(log);
          } 
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        } 
      } else {
          log = {"status": false, "number":null, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      }

  });

  app.post('/send-contact', async(req, res) => {
      var number = req.body.number;
      var name = req.body.name;
      var phone = req.body.phone;
      var organization = req.body.organization;
      var token = req.body.instance;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && name && phone && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {
                  const vcard = 'BEGIN:VCARD\n' // metadata of the contact card
                  + 'VERSION:3.0\n' 
                  + 'FN:'+name+'\n' // full name
                  + 'ORG:'+organization+';\n' // the organization of the contact
                  + 'TEL;type=CELL;type=VOICE;waid='+phone+':+'+phone+'\n' // WhatsApp ID + phone number
                  + 'END:VCARD'
                  conn[token].sendMessage(number, {displayname: name, vcard: vcard}, MessageType.contact);
                  log = {"status": true, "number":number, "message":"Terkirim"};
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                }
                res.send(log);
              } else {
                  log = {"status": false, "number":number, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":number, "message":"Number, Nama, Phone, Organisasi dan Token tidak boleh kosong"}
              res.send(log);
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        }
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      }  

  });

  app.post('/send-image', async(req, res) => {
      var number = req.body.number;
      var urlimage = req.body.image;
      var token = req.body.instance;
      var caption = req.body.caption;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && urlimage && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {          
                urlimage = urlimage.toString().replace("/","\/");
                axios.get(urlimage)
                  .then((result) => {
                    imageToBase64(urlimage) // Path to the image
                    .then(
                        (response) => {
                        var buf = Buffer.from(response, 'base64'); // Ta-da 
                          conn[token].sendMessage(
                        number,
                          buf,MessageType.image, {caption:caption})
                   
                        }
                    )
                    .catch(
                        (error) => {
                            console.log(error); // Logs an error if there was one
                        }
                    )
                
                });
                  log = {"status": true, "number":number, "message":"Terkirim"};
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                }
                res.send(log);
              } else {
                  log = {"status": false, "number":number, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":number, "message":"Number, Image dan Token tidak boleh kosong"}
              res.send(log);
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        }
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      }  

  });

  function base64Encode(file) {
      let body = fs.readFileSync(path.resolve(file));
      return body.toString('base64');
  }


  app.post('/send-document', async(req, res) => {
      var number = req.body.number;
      var urldocument = req.body.document;
      var token = req.body.instance;
      //var filename = req.body.filename;

      let content;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && urldocument && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {  
                  //urldocument = urldocument.toString().replace("/","\/");
                  //const buffer = Buffer.from(urldocument, "binary")
                  var randfile = makeid(10);
                  
                  //console.log(path.basename(parsed.pathname));
                  var parsed = url.parse(urldocument);
                  var filename = path.basename(parsed.pathname);
                  var fullpath = path.normalize(__dirname + "/temp/"+randfile+"-"+filename);
                  var filepath = __dirname+"/temp/"+randfile+"-"+filename;
                  var ext = path.extname(urldocument);
                  downloadFile(urldocument,fullpath);

                  var file = path.normalize(__dirname + '/temp/'+randfile+"-"+filename);
                  var request = require('request');

                  request.get(urldocument, function (error, response, body) {
                      if (!error && response.statusCode == 200) {
                          // Continue with your processing here.
                          if (fs.existsSync(file)) {
                            let bf = fs.readFileSync(file);
                            //console.log(bf);
                            conn[token].sendMessage(number, bf, MessageType.document, {filename:filename, mimetype:ext});
                            log = {"status": true, "number":number, "message":"Terkirim"};
                            res.send(log);
                            fs.unlinkSync(file);
                          } else {
                            log = {"status": false, "number":number, "message":"Gagal kirim pesan. Silahkan kirim ulang!"};
                            res.send(log);
                          }
                      }
                  }); 
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                  res.send(log);
                }    
                
              } else {
                  log = {"status": false, "number":number, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":number, "message":"Number, Document dan Token tidak boleh kosong"}
              res.send(log);
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        }
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      }  

  });

  app.post('/send-video', async(req, res) => {
      var number = req.body.number;
      var urlvideo = req.body.video;
      var token = req.body.instance;
      var caption = req.body.caption;

      let content;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && urlvideo && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {
                
                  //urldocument = urldocument.toString().replace("/","\/");
                  //const buffer = Buffer.from(urldocument, "binary")
                  var randfile = makeid(10);
                  var parsed = url.parse(urlvideo);
                  //console.log(path.basename(parsed.pathname));
                  var filename = path.basename(parsed.pathname);
                  var fullpath = path.normalize(__dirname + "/temp/"+randfile+"-"+filename);
                  var filepath = __dirname+"/temp/"+randfile+"-"+filename;
                  var ext = path.extname(urlvideo);
                  downloadFile(urlvideo,fullpath);

                  var file = path.normalize(__dirname + '/temp/'+randfile+"-"+filename);
                  var request = require('request');

                  request.get(urlvideo, function (error, response, body) {
                      if (!error && response.statusCode == 200) {
                        if (fs.existsSync(file)) {
                          // Continue with your processing here.
                          let bf = fs.readFileSync(file);
                          //console.log(bf);
                          conn[token].sendMessage(number, bf, MessageType.video, {mimetype:Mimetype.gif, caption: caption});
                          log = {"status": true, "number":number, "message":"Terkirim"};
                          res.send(log);
                          fs.unlinkSync(file);
                      }
                    } else {
                        log = {"status": false, "number":number, "message":"Gagal kirim pesan. Silahkan kirim ulang!"};
                        res.send(log);
                    }     
                  });
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                  res.send(log);
                } 
                
              } else {
                  log = {"status": false, "number":number, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":number, "message":"Number, Document dan Token tidak boleh kosong"}
              res.send(log);
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        }  
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      }

  });

  app.post('/send-audio', async(req, res) => {
      var number = req.body.number;
      var urlaudio = req.body.audio;
      var token = req.body.instance;
      //var filename = req.body.filename;

      let content;

     // console.log(req.body);
     if(conn[token]) {
      if(conn[token].phoneConnected) {
        if (number && urlaudio && token){
            if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {
                  //urldocument = urldocument.toString().replace("/","\/");
                  //const buffer = Buffer.from(urldocument, "binary")
                  var randfile = makeid(10);
                  var parsed = url.parse(urldocument);
                  //console.log(path.basename(parsed.pathname));
                  var filename = path.basename(parsed.pathname);
                  var fullpath = path.normalize(__dirname + "/temp/"+randfile+"-"+filename);
                  var filepath = __dirname+"/temp/"+randfile+"-"+filename;
                  var ext = path.extname(urldocument);
                  downloadFile(urldocument,fullpath);

                  var file = path.normalize(__dirname + '/temp/'+randfile+"-"+filename);
                  var request = require('request');

                  request.get(urldocument, function (error, response, body) {
                      if (!error && response.statusCode == 200) {
                        if (fs.existsSync(file)) {
                          // Continue with your processing here.
                          let bf = fs.readFileSync(file);
                          //console.log(bf);
                          conn[token].sendMessage(number, bf, MessageType.audio, {filename:filename, mimetype:ext});
                          log = {"status": true, "number":number, "message":"Terkirim"};
                          res.send(log);
                          fs.unlinkSync(file);
                      }
                    } else {
                        log = {"status": false, "number":number, "message":"Gagal kirim pesan. Silahkan kirim ulang!"};
                        res.send(log);
                    }  
                  });
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                  res.send(log);
                }      
              
            } else {
                log = {"status": false, "number":number, "message":"Instance salah!"}
                console.log(log);
                res.send(log);
            }
        } else {
            log = {"status": false, "number":number, "message":"Number, Document dan Token tidak boleh kosong"}
            res.send(log);
        }
      } else {
          log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
          res.send(log);
      }  
    } else {
        log = {"status": false, "number":number, "message":"Instance salah!"}
        console.log(log);
        res.send(log);
    }

  });

  app.post('/send-link', async(req, res) => {
      var number = req.body.number;
      var urllink = req.body.url;
      var token = req.body.instance;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && urllink && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {
                  conn[token].sendMessage(number, urllink, MessageType.extendedText);
                  log = {"status": true, "number":number, "message":"Terkirim"};
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                }
                res.send(log);
              } else {
                  log = {"status": false, "number":number, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":number, "message":"Number, Image dan Token tidak boleh kosong"}
              res.send(log);
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        } 
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      } 

  });

  app.post('/send-location', async(req, res) => {
      var number = req.body.number;
      var latitude = req.body.latitude;
      var longitude = req.body.longitude;
      var token = req.body.instance;

      //console.log(req.body);
      if(conn[token]) {
        if(conn[token].phoneConnected) {
          if (number && latitude && longitude && token){
              if(conn[token]) {
                const exists = await conn[token].isOnWhatsApp (number)
                if (exists || number.match(/-/g) == "-") {
                  conn[token].sendMessage(number, {degreesLatitude: latitude, degreesLongitude: longitude} ,MessageType.location);
                  log = {"status": true, "number":number, "message":"Terkirim"};
                } else {
                  log = {"status": false, "number":number, "message":"Belum_Terdaftar_Whatsapp"}
                }
                res.send(log);
              } else {
                  log = {"status": false, "number":number, "message":"Instance salah!"}
                  console.log(log);
                  res.send(log);
              }
          } else {
              log = {"status": false, "number":number, "message":"Number, Message dan Token tidak boleh kosong"}
              res.send(log);
          }
        } else {
            log = {"status": false, "number":null, "message":"Instance DISCONNECTED"}
            res.send(log);
        }
      } else {
          log = {"status": false, "number":number, "message":"Instance salah!"}
          console.log(log);
          res.send(log);
      }  

  });
}

app.post('/send', async(req, res) => {
  var token        = req.body.instance;
  var phone        = ToWa(req.body.number) || ToWa(req.body.phone);
  var msg          = decodeEntities(req.body.message);
  var fileUrl      = req.body.file_url || ""; 
  var fileName     = req.body.fileName || "_";    
  var type_message = req.body.type_message || "default";    
  // console.log(phone,msg,port);
  // console.log(req.body);
  try {
    if(conn[token]) {
      if (phone && msg && port){
          if(conn[token].phoneConnected) {
            const exists = await conn[token].isOnWhatsApp (phone)
            if (exists || phone.match(/-/g) == "-") {
              // await wa.chatRead(phone) // mark chat read
              await conn[token].updatePresence(phone, Presence.available) // tell them we're available
              await conn[token].updatePresence(phone, Presence.composing) // tell them we're composing
              
              if(fileUrl!==""){
                const urlExist =  require("url-exists");
                urlExist(fileUrl, async function(err, exists) {
                  console.log(exists); // true
                  if(exists){
                    fileUrl = fileUrl.toString().replace("/","\/");
                    let mimetype;
                    const attachment = await axios.get(fileUrl)
                        .then(result => {
                            mimetype = result.headers['content-type'];
                            imageToBase64(fileUrl).then(async response=>{                                
                                let buf = await Buffer.from(response, 'base64');
                                let Type = MessageType.image;
                                let mtype = Mimetype.jpeg;
                                var ext = path.extname(fileUrl);
                                console.log(buf);
                                if(mimetype.indexOf('application')>=0){
                                    Type = MessageType.document;
                                    mtype = Mimetype.pdf;
                                    conn[token].sendMessage(phone, buf,Type,{caption:msg,mimetype:ext,filename:fileName}).then(resp=>{
                                        let caption_file = conn[token].sendMessage(phone, msg ,MessageType.text);
                                        let id= resp.key.id;                
                                        res.status(200).json({
                                            "status": true,                                      
                                            "message": "Terkirim",
                                            "instance": token,
                                            "data": {"messageid":id,"server_phone":ToPhone(mynumber[token]),"phone":ToPhone(phone),"status":2,"timestamp":resp.messageTimestamp.low}
                                        });
                                    }).catch(err=>{
                                        console.log(err);
                                        res.json({
                                            "status": false,
                                            "instance": token,
                                            "message": err,
                                            "data": {}
                                        });
                                    });
                                }else if(mimetype.indexOf('video')>=0){
                                    Type = MessageType.video;
                                    conn[token].sendMessage(phone, buf,Type,{caption:msg,mimetype:ext,filename:fileName}).then(resp=>{
                                      let id= resp.key.id;                
                                      res.status(200).json({
                                          "status": true,                                      
                                          "message": "Terkirim",
                                          "instance": token,
                                          "data": {"messageid":id,"server_phone":ToPhone(mynumber[token]),"phone":ToPhone(phone),"status":2,"timestamp":resp.messageTimestamp.low}
                                      });
                                    }).catch(err=>{
                                        console.log(err);
                                        res.json({"status": true,"message": err,"data": {}});
                                    });
                                }else if(mimetype.indexOf('image')>=0){
                                  Type = MessageType.image;  
                                  mtype = Mimetype.jpg;      
                                  conn[token].sendMessage(phone, buf,Type,{caption:msg}).then(resp=>{
                                        let id= resp.key.id;                
                                        res.status(200).json({
                                            "status": true,                                            
                                            "message": "Terkirim",
                                            "instance": token,
                                            "data": {"messageid":id,"server_phone":ToPhone(mynumber[token]),"phone":ToPhone(phone),"status":2,"timestamp":resp.messageTimestamp.low}
                                        });
                                    }).catch(err=>{
                                        res.json({
                                            "status": true,
                                            "instance": token,
                                            "message": err,
                                            "data": {}
                                        });
                                    });                                                  
                                }else{
                                  conn[token].sendMessage(phone, buf,Type,{caption:msg,mimetype:ext,filename:fileName}).then(resp=>{
                                      let id= resp.key.id;                
                                      res.status(200).json({
                                          "status": true,                                      
                                          "message": "Terkirim",
                                          "instance": token,
                                          "data": {"messageid":id,"server_phone":ToPhone(mynumber[token]),"phone":ToPhone(phone),"status":2,"timestamp":resp.messageTimestamp.low}
                                      });
                                  }).catch(err=>{
                                      console.log(err);
                                      res.json({"status": true,"message": err,"data": {}});
                                  });
                                }
                                console.log(Type,ext,mimetype);
                                
                                
                            }).catch(err=>{
                                console.log(err);
                            });                        
                    });  
                  }else{
                    res.status(201).json({
                        "status": false,
                        "instance": token,
                        "message": "File Not Valid",
                        "data": {"phone":ToPhone(phone)}
                    });
                  }
                });           

                }else{
                    let resp = await  conn[token].sendMessage(phone, msg ,MessageType.text);
                    let id= resp.key.id;                
                    res.status(200).json({
                        "status": true,                       
                        "instance": token,
                        "message": "Terkirim",
                        "data": {"messageid":id,"server_phone":ToPhone(mynumber[token]),"phone":ToPhone(phone),"status":2,"timestamp":resp.messageTimestamp.low}
                    });
                }

            } else {
              res.status(201).json({
                  "status": false,
                  "instance": token,
                  "message": "Belum_Terdaftar_Whatsapp",
                  "data": {"phone":ToPhone(phone)}
              });
            }
          } else {
              res.status(200).json({
                  "status": false,
                  "instance": token,
                  "message": "Device Not Start",
                  "data": {}
              });
          }
      } else {
          log = {"status": false, "phone":null, "message":"Number, Message dan Token tidak boleh kosong"}
          res.send(log);
      } 
    } else {
      res.status(200).json({
          "status": false,
          "instance": token,
          "message": "Device Disconnected",
          "data": {}
      });
    }
  } catch (error) {
    console.log(error);
  }
   

});


app.get('/devices',async(req, res) => {
  if (fs.existsSync(`devices6.json`)) {
    const data = JSON.parse(fs.readFileSync(`./devices6.json`, 'utf8')); //require(`./devices6.json`);
    let devices = [];
    for (let i = 0; i < data.length; i++) {
      const row = data[i];
      let token = row['id'];
      if(conn[token]){
        if(conn[token].phoneConnected){
          // let pic = await conn[token].getProfilePicture (conn[token].user.jid) || '';
          // getppUrl = await conn[token].getProfilePicture (number)
          let log = {"instance":token, "isActive":true,"phone":ToPhone(conn[token].user.jid),"name":conn[token].user.name,"pic":PicProfile[token],"battery":batterylevel[token]||0};
          devices.push(log);
        }else{
          let log = {"instance":token ,"isActive":true,"phone":null,"name":null,"pic":'',"battery":null};
          devices.push(log);
        }
      }
    }
    res.status(200).json({
      "status": true,
      "msg": "All Diveces",
      "data": {devices}
  });
  }else{
    res.status(200).json({
      "status": false,
      "msg": "No Divece Found",
      "data": {}
  });
  }
});

function getNo() {
  var max = 0;
  if(fs.existsSync(`devices6.json`)){
    const data = require(`./devices6.json`);
    for (var i=0 ; i<data.length ; i++) {
      const row = data[i];
      let no = parseInt(row['no']); 
      max = no > max ? no : max;
      console.log(max);
    }
  }  
  return max +1;
}

//newinstance(0,0);
async function GetDvices(){
  fs.writeFile(`devices6.json`, '[]', function(){console.log('done')});
  return axios.get(deviceUrl).then(body=>{  
  var jsonData = body.data;
  let number = 1;
    for (var i = 0; i < jsonData.length; i++) {
        var e = jsonData[i];
        console.log(e);         
        setValue.push({ 
          id: e.device_id.toString(),
          no: number
        });
        datanew = JSON.stringify(setValue, null, '\t');
        fs.writeFileSync(`devices6.json`, datanew);     
        newinstance(e.device_id, number);  
        console.log('device start ',e.device_id);
        number = number + 1;
    }    
  });
}

// GetDvices();

function deleteSession(filepath){
  if (fs.existsSync(filepath)) {
    fs.unlink(filepath, function(err){
      if (!err) {
        console.log(`[ ${moment().format("HH:mm:ss")} ] => Sukses hapus Session`);
        //client.initialize();  
      } else {
        console.log(`[ ${moment().format("HH:mm:ss")} ] => Gagal hapus Session!`);
      }
    });
  }   
}
function deleteFile(path){
  if (fs.existsSync(path)) {
    fs.unlink(path, function(err){
      if (!err) {
        console.log(`[ ${moment().format("HH:mm:ss")} ] => Sukses hapus File`);
        //client.initialize();  
      } else {
        console.log(`[ ${moment().format("HH:mm:ss")} ] => Gagal hapus File!`);
      }
    });
  }   
}
function downloadFile (url, file_path){
  axios({
    url,
    responseType: 'stream',
  }).then(
    response =>
      new Promise((resolve, reject) => {
        response.data
          .pipe(fs.createWriteStream(file_path))
          .on('finish', () => resolve())
          .on('error', e => reject(e));
      }),

);
  var msg = "OK";
  return msg;
}

function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQR[number]STUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function close(token) {
  if(conn[token]) {
      conn[token].clearAuthInfo();
      QR[token] = null;
      conn[token].close();
      conn[token] = null;
      qrke[token] = null;
      let dataRemoved;
      if (fs.existsSync(`devices6.json`)) {
        const dataRemoved = require(`./devices6.json`);            
          if(dataRemoved !== null) {
            let nomor =1;
            dataRemoved.forEach(obj => {
                Object.entries(obj).forEach(([key, value]) => {
                  //setValue = array(key,value);  
                  if(key == "id" && value != token) {
                      setValue.push({ 
                        id: value,
                        no: nomor
                      });
                      datanew = JSON.stringify(setValue, null, '\t');
                      fs.writeFileSync(`devices6.json`, datanew);
                  }
                });
                nomor = nomor + 1;
            });
                
          }
      }
      console.log('Session ' + token + ' tutup karena tidak discan...');    
  } else {
    console.log('Session ' + token + ' Tidak ditemukan');      
  }
}

app.listen(port, () => console.log(`app listening at http://localhost:${port}`));

const newAntrian = async (device_id) => {          
  antrian[device_id] = new MyEmitter();
  antrian[device_id].on('start', () => {
      // console.log('start event');
      // console.log("cek antrian on device :",device_id);
        con.query("select * from antrians where status=1 and device_id="+device_id+" limit 0,1",async function(err,rows,field){
            if(err)console.log('err ',err);
          //   console.log(rows.length);
            if(rows.length==0){
                setTimeout(() => {
                  console.log("["+device_id+"] Restart Antrian");
                  antrian[device_id].emit('pause');
                }, 1000);
            }
            for (let i = 0; i < rows.length; i++) {
                const ant = rows[i];
                // console.log(ant);                        
                let data = {instance: ant.device_id.toString() || ant.device_id,"phone":ant.phone,"message":TimeReplace(ant.message),"file_url":ant.file,"file_name":ant.file_name}; //
              //   console.log('Data Kirim :',data);
                let kirim = await axios.post(apiurl+"/send",data);
                console.log('Log Kirim :',kirim.data);
                let laporan = {"id":ant.id,"pause":ant.pause,"messageid" : kirim.data.data.messageid || null,"message" : kirim.data.message || null,"data":TimeReplace(ant.message)||null};
                antrian[device_id].emit('finish',laporan);
            }
        });
    });
    
    antrian[device_id].on('finish',async (data) => {
        console.log('Pause : ' + data.pause ,data);          
        con.query("update antrians set status="+(data.message=='Terkirim' ? 2 : 3 )+",messageid='"+(data.messageid || 'Error' )+"',report='"+(data.message || 'No Report')+"' where id="+data.id,function(er,res){
          setTimeout(() => {
              antrian[device_id].emit('start');
            }, 1000 * data.pause);
        });                      
    });

    antrian[device_id].on('pause',() => {
      console.log('pause event');
      setTimeout(() => {         
          antrian[device_id].emit('start');
      }, 20000);
  });

    antrian[device_id].emit('start');
}

// newAntrian("1");

async function CekStatus(){  
  return axios.get(deviceUrl).then(body=>{  
  var jsonData = body.data;
    for (var i = 0; i < jsonData.length; i++) {
        var e = jsonData[i];
        let id_device = e.device_id.toString();
        if(!conn[id_device]){
          newinstance(id_device,id_device)
          console.log("Device baru dijalankan", id_device);
        }else{
          if (conn[id_device].phoneConnected) {
            // Online
            console.log('Online :',id_device);            
          } else {
              if(QR[id_device]!=''){
                // Ready to Scan
                console.log('Ready Scan :',id_device);
              }else{
                // Restart
                console.log('Restart device :',id_device);
                conn[id_device].clearAuthInfo();        
                QR[id_device] = null;        
                conn[id_device] = null;                          
                newinstance(id_device,no_device);                
                console.log("Device restart dijalankan", id_device);
              }
          }              
        }
    }    
  });
}

// setTimeout(() => {
//   CekStatus();
// }, 1000);


