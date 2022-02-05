<?php

namespace App\Helpers;

use App\Models\Device;

class Whatsapp
{
    public static function start($data)
    {
        return self::curl("api/start", $data);
    }

    public static function qrcode($data)
    {
        return self::curl("api/qrcode", $data, "GET");
    }

    public static function send($data)
    {
        return self::curl("api/send", $data);
    }

    public static function group($data)
    {
        return self::curl("api/group-list", $data);
    }

    public static function queue($data)
    {
        return self::curl("api/antrian", $data);
    }

    public static function delete($data)
    {
        return self::curl("api/delete-antrian", $data);
    }

    public static function logout($data)
    {
        return self::curl("api/logout", $data, "POST");
    }

    public static function cpu()
    {
        $device = Device::first();
        return self::curl("cpu", ['token'=>$device->id], "GET");
    }

    public static function list()
    {
        $device = Device::first();
        return self::curl("api/devices", ['token'=>$device->id], "GET");
    }

    public static function servers()
    {
        $device = Device::first();
        return self::curl("api/servers", ['token'=>$device->id], "GET");
    }

    public static function restart()
    {
        $device = Device::first();
        return self::curl("api/restart", ['token'=>$device->id]);
    }

    static function curl($url, $data, $method = "POST")
    {
        $device = Device::where('id', $data['token'])->first();
        // return $device;
        if ($device) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $device->server->ip . ":" . $device->server->port . "/" . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "apikey: " . $device->server->apikey

                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return [
                    'status' => false,
                    'message' => "cURL Error #:" . $err,
                ];
            } else {
                return $response;
            }
        } else {
            return $data;
        }
    }
}
