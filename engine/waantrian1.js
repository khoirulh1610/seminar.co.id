require('dotenv').config({path:'../.env'});
const axios = require("axios");
const exec = require('child_process').exec;
const { ToWa,ToPhone } = require('./lib');
const port = process.env.APP_WA_PORT;

const apiurl = "http://localhost:"+port;
const Antr=[];
var mysql = require('mysql');
var con  = mysql.createPool({
    // connectionLimit : 500,
    host            : process.env.DB_HOST,
    user            : process.env.DB_USERNAME,
    password        : process.env.DB_PASSWORD,
    database        : process.env.DB_DATABASE,
    port            : process.env.DB_PORT
  });
con.query('SELECT 1 + 1 AS solution', function (error, results, fields) {
  // should actually use an error-first callback to propagate the error, but anyway...
  if (error) return console.error(error);
  console.log('Cek Koneksi : ', results[0].solution>0 ? 'Online' : 'Offline');
});

GetDeviceReady();


async function GetDeviceReady(){
    con.query("select * from devices",function(err,rows,filed){
        if(err) console.log(err);
        for (let i = 0; i < rows.length; i++) {
            const device = rows[i];
            // console.log(device);
            antrian(device.id);
        }
    });
}

const antrian = async (device_id)=>{
    console.log("cek antrian on device :",device_id);
    con.query("select * from antrians where status=1 and device_id="+device_id+" limit 0,1",async function(err,rows,field){
        if(err)console.log('err ',err);
        console.log(rows.length);
        if(rows.length==0){
            setTimeout(() => {
                antrian[device_id];
            }, 30000);
        }
        for (let i = 0; i < rows.length; i++) {
            const ant = rows[i];
            console.log(ant);
            await con.query("update antrians set status=2 where id="+ant.id);            
            let kirim = await axios.post(apiurl+"/send",{instance:"1","phone":ant.phone,"message":ant.message,"file_url":ant.file,"file_name":ant.file_name});
            console.log('Log Kirim :',kirim);
            await await con.query("update antrians set status=2,att1='"+(kirim.messageid || 'Error' )+"' where id="+ant.id);            
            setTimeout(() => {
                antrian[device_id];
            }, ant.pause*1000);
        }
    });
}
