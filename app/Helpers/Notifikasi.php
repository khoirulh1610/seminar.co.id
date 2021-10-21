<?php

namespace App\Helpers;
use App\Helpers\Notifikasi;

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
}