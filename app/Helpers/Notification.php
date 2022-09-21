<?php

namespace App\Helpers;

use App\Models\Device;
use App\Models\Notification as ModelsNotification;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class Notification
{
    protected $async = false;
    protected $phone = [];
    protected $data = [];
    protected $notification;
    private $device;
    private $copywriting = null;
    private $message = null;
    private $create_action = false;
    private $create = false;
    private $save_table = 'antrians';

    public static function make(String $notification_name)
    {
        return (new self())->name($notification_name);
    }

    public function device($device)
    {
        if ($device instanceof Device) {
            $this->device = $device->id;
        } else {
            $this->device = $device;
        }
        return $this;
    }

    public function name(String $notification_name)
    {
        $this->notification = ModelsNotification::firstWhere('slug', $notification_name);
        if ($this->notification == null) {
            throw new Exception('Notification data not found');
        }
        $this->device($this->notification->device_id);
        $this->copywriting($this->notification->text);
        return $this;
    }

    /**
     * @param Array|Model $data
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Jika diisi manual will overwrite copywriting text 
     */
    public function copywriting(String $copywriting)
    {
        $this->copywriting = $copywriting;
        return $this;
    }


    /**
     * @param String|Array $phone nomor atau JID group WA
     * @return $this
     * 
     */
    public function phone($phone)
    {
        if (gettype($phone) == 'string') {
            $this->phone = ["{$phone}"];
        } else {
            $this->phone = $phone;
        }
        return $this;
    }


    /**
     * Menyimpan Notifikasi ke tabel antrian notifikasi
     */
    private function create(): void
    {
        $this->create_action = true;
        $data = [];
        $now = now();
        $this->generateMessage();
        foreach ($this->phone as $phone) {
            array_push($data, [
                'status' => 1,
                'user_id' => 2,
                'device_id' => $this->device,
                'message' => $this->message,
                'phone' => $phone,
                'type' => 'wa',
                'type_message' => 'text',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        $this->create = DB::table($this->save_table)->insert($data);
    }


    public function save($table_name = 'antrians')
    {
        $this->save_table = $table_name;
        $this->create();
        return $this;
    }


    /**
     * Enable async mode 
     * Use Job queue 
     */
    public function async()
    {
        $this->async = true;
        return $this;
    }

    /**
     * Send notification to phone number given
     */
    public function send()
    {
        if ($this->async) {
            return $this->asyncSend();
        } else {
            $this->generateMessage();
            $res = $this->sendProccess();
            return [
                'result' => $res,
                'message' => $this->message
            ];
        }
    }

    /**
     * Send notification to phone number given with async mode
     */
    public function asyncSend()
    {
        $this->generateMessage();
        dispatch(function () {
            $this->sendProccess();
        });
        return Artisan::call('queue:work --stop-when-empty');
    }

    private function sendProccess()
    {
        $report = [];
        foreach ($this->phone as $value) {
            $res = Whatsapp::send([
                "token" => "{$this->device}",
                "phone" => $value,
                "message" => $this->message
            ]);
            array_push($report, [
                'phone' => $value,
                'res' => $res
            ]);
        }
        return $report;
    }

    private function generateMessage(): void
    {
        if ($this->copywriting == null) {
            throw new Exception("Require copywriting value, please insert copywriting text with call copywriting() method", 1);
        }
        if ($this->message == null) {
            $this->message = ReplaceArray($this->data, $this->copywriting);
        }
    }
}
