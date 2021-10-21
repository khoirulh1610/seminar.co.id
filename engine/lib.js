const fs = require('fs');
const axios = require('axios');
function downloadImage (url, image_path){
  axios({
    url,
    responseType: 'stream',
  }).then(
    response =>
      new Promise((resolve, reject) => {
        response.data
          .pipe(fs.createWriteStream(image_path))
          .on('finish', () => resolve())
          .on('error', e => reject(e));
      }),

);
}

const ToWa = function(number) {
    // 1. Menghilangkan karakter selain angka
    if(number!==undefined){
      if (number.endsWith('@g.us')) {
        return number;
      }else{
        let formatted = number.replace(/\D/g, '');  
        if (formatted.startsWith('0')) {
          formatted = '62' + formatted.substr(1);
        }
        if (!formatted.endsWith('@c.us')) {
          formatted += '@c.us';
        }
        return formatted;
      }      
    }else{
      formatted = number;
      return formatted;
    }
    
  
    
  }
  
  const ToPhone = function(number) {
    if(number!==undefined){
      if (number.endsWith('@g.us')) {
        return number;
      }else{
        let formatted = number.toString().replace(/\D/g, '');  
        return formatted;
      }      
    }else{
      return number;
    }
    
  }
  
  function decodeEntities(encodedString) {
    var translate_re = /&(nbsp|amp|quot|lt|gt);/g;
    var translate = {
        "nbsp":" ",
        "amp" : "&",
        "quot": "\"",
        "lt"  : "<",
        "gt"  : ">"
    };
    return encodedString.replace(translate_re, function(match, entity) {
        return translate[entity];
    }).replace(/&#(\d+);/gi, function(match, numStr) {
        var num = parseInt(numStr, 10);
        return String.fromCharCode(num);
    });
  }
  
  
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
  
module.exports = {
  ToWa,ToPhone,decodeEntities,TimeReplace,downloadImage
}


