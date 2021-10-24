<?php

namespace App\Helpers;
use App\Helpers\Notifikasi;
use App\Models\user;

class Notifikasi{

    public static function send($data)
    {
        $engine= $data->engine ?? "quods";
        return self::$engine($data);
    }

    static function quods($data)
    {
        $url = "https://quods.id/api/whatsapp/send";
        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:application/json','Authorization:Bearer thz9ngvyI5V0nHcRXVfUZFcKVqBVQP'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 400); //timeout in seconds
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    static function fcmAll($data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::where('role_id','<=',3)->whereNotNull('device_token')->pluck('device_token')->all();
          
        $serverKey = 'AAAATi93QOI:APA91bGaMyVJXtUWPJ2MxFN28ycoP_q4e1XY8VHgLz_iqCKDjgpYIuctJV8USdXaugAbpMnYENE6E3wvt8_5ytsuMMC_pBYC0tsR-WpZQzuPtgm5wRDBNUvObCdseivdSXj8I8CD-dty';
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => $data
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        

        // Close connection
        curl_close($ch);
        \Log::info($result);
        // FCM response
        // dd($result);        
    }
}