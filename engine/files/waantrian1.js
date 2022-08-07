require('dotenv').config({path:'../.env'});
const axios = require("axios");
const exec = require('child_process').exec;
var EventEmitter = require('events');
var eventAntrian = new EventEmitter.EventEmitter();
const { ToWa,ToPhone } = require('./lib');

const port = process.env.APP_WA_PORT;
const apiurl = "http://localhost:"+port;
const antrian=[];
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
  // should actually use an error-first callback to propagate the error, but anyway...
  if (error) return console.error(error);
  console.log('Cek Koneksi : ', results[0].solution>0 ? 'Online' : 'Offline');
});


class MyEmitter extends EventEmitter {}

GetDeviceReady();
setInterval(() => {
    GetDeviceReady();
}, 2 * 60 * 1000 );
async function GetDeviceReady(){
    con.query("select * from devices",function(err,rows,filed){
        if(err) console.log(err);
        for (let i = 0; i < rows.length; i++) {
            const device = rows[i];
              if(device.status=='AUTHENTICATED'){
                if(!antrian[device.id]){
                  newAntrian(device.id);
                }
              }else{
                console.log('Terputus : ',device.id);
              }
        }
    });
}

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

function TimeReplace(waktu) {
  let Jam = new Date().getHours();
  let Hasil = "";
  if (Jam>=0 && Jam<10){
      Hasil = "Pagi";
  }else if (Jam >=10 && Jam<15){
      Hasil = "Siang";
  }else if (Jam >=15 && Jam<=17){
      Hasil = "Sore";
  }else{
      Hasil = "Malam";
  }
  return waktu.replace(/Malam|Sore|Siang|Pagi/g, Hasil);
}
