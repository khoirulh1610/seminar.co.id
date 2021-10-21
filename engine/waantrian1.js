const axios = require("axios");
const exec = require('child_process').exec;
const { ToWa,ToPhone } = require('./lib');

const apiurl = "http://localhost:5001";
const Antr=[];
var mysql = require('mysql');
var con  = mysql.createPool({
  // connectionLimit : 500,
  host            : 'localhost',
  user            : 'mrquods',
  password        : '@345Ga&_OkeB2ss',
  database        : 'seminar',
  port            : "33063"
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
            await axios.post(apiurl+"/send",{instance:"1","phone":ant.phone,"message":ant.message});
            setTimeout(() => {
                antrian[device_id];
            }, ant.pause*1000);
        }
    });
}
