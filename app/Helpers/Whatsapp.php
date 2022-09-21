<?php

namespace App\Helpers;

use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public static function send($data, $save_response = false)
    {
        $res =  self::curl("api/send", $data);
        if ($save_response) {
            self::saveNotif([
                "token" => $data['token'] ?? 0,
                "phone" => $data['phone'] ?? 0,
                "message" => $data['message'] ?? 0,
            ], $res);
        }
        return $res;
    }

    public static function group($data)
    {
        return self::curl("api/group-list-with-contact", $data);
    }

    public static function isWA($data)
    {
        if ($data['phone'] ?? false) {
            $data = self::curl("api/iswa", $data);
            if (gettype($data) == "string") {
                return json_decode($data, true);
            }
            return $data;
        } else {
            return [
                'status' => false,
                'message' => 'Phone number is required',
            ];
        }
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
        return self::curl("cpu", ['token' => $device->id], "GET");
    }

    public static function list()
    {
        $device = Device::first();
        return self::curl("api/devices", ['token' => $device->id], "GET");
    }

    public static function servers()
    {
        $device = Device::first();
        return self::curl("api/servers", ['token' => $device->id], "GET");
    }

    public static function restart()
    {
        $device = Device::first();
        return self::curl("api/restart", ['token' => $device->id]);
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
                return json_encode([
                    'status' => false,
                    'message' => "cURL Error #:" . $err,
                ]);
            } else {
                return $response;
            }
        } else {
            return json_encode($data);
        }
    }

    public static function saveNotif(array $data, $res)
    {
        $res = json_decode($res, true);

        $device_id = $data['token'];
        $device = Device::find($device_id);
        $now = Carbon::now();
        return DB::table("zu{$device->user_id}_antrians")->insert([
            'user_id' => $device->user_id,
            'device_id' => $device_id,
            'phone' => $data['phone'],
            'type' => 'wa auto-save',
            'type_message' => 'text',
            'message' => $data['message'],
            'status' => $res['message'] == 'Terkirim' ? 2 : 3,
            'report' => $res['message'] ?? null,
            'messageid' => $res['messageid'] ?? null,
            'pause' => 1,
            'priority' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function kemaxwin($data)
    {
        # code...
        $curl           = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://membermaxwin.my.id/api/aktivasi',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data
        ));

        $data = curl_exec($curl);
        curl_close($curl);
    }
}
