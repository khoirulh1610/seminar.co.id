<?php

namespace App\Helpers;
use App\Helpers\Whatsapp;

class Whatsapp{

    public static function host()
    {
        return "http://127.0.0.1:".ENV('APP_WA_PORT',7001)."/";
    }

    public static function start($data)
    {
        return self::curl(self::host()."new",$data);
    }

    public static function qrcode($data)
    {
        return self::curl(self::host()."qrcode",$data);
    }

    public static function send($data)
    {
        return self::curl(self::host()."send",$data);
    }

    public static function reset($data)
    {
        $close = self::curl(self::host()."close",$data,"GET");
        return   self::curl(self::host()."new",$data);
    }
    
    public static function getcontacts($data)
    {
        return self::curl(self::host()."getcontacts",$data,"GET");
    }

    public static function getgroup($data)
    {
        return self::curl(self::host()."group-info",$data,"GET");
    }

    public static function logout($data)
    {
        return self::curl(self::host()."logout",$data,"GET");
    }

    static function curl($url,$data,$method="POST")
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_PORT => ENV('APP_WA_PORT',"7001"),
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}