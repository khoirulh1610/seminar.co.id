<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Whatsapp;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Device;
use App\Models\Event;
use App\Models\Seminar;
use App\Models\Warespon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AntrianController extends Controller
{
    public function antrian()
    {
        $data = file_get_contents("php://input");
        // Log::info($data);
        if ($data) {
            try {
                $a = json_decode($data);
                $token = $a->token;
                $device = Device::where('id', $token)->first();
                if ($device) {
                    $tb = "zu" . $device->user_id . "_antrians";
                    // Log::info("Cek DV Pesan ". $tb);                    
                    $Kirimpesan = DB::table($tb)->Where('id', $a->refid)->first();
                    if ($Kirimpesan) {
                        // Log::info("upadate Pesan");
                        $Kirimpesan = DB::table($tb)->Where('id', $a->refid)->update([
                            "messageid" => $a->messageid ?? null,
                            "report"   => $a->report ?? null,
                            "status"   => $a->report == 'Terkirim' ? 2 : 3
                        ]);
                    }
                }
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }

    public function device()
    {
        # code...
    }

    public function callback(Request $request)
    {
        $data           = file_get_contents("php://input");
        $cal            = json_decode($data);
        // Log::info('callback', $cal);
        $type           = $cal->type ?? null;
        $device_id      = $cal->token;
        $phone          = $cal->phone ?? false;
        $message        = $cal->message ?? '';
        $token          = $cal->token ?? 0;
        $device         = Device::where('id', $device_id)->first();
        $tb_res         = "user" . $device->user_id . "_respons";
        // Log::info('callback type', [$type]);
        if ($phone && strtolower($message) == 'hadir') {
            $seminar    = Seminar::where('phone', $phone)->where('tgl_seminar', Date('Y-m-d'))->first();
            if ($seminar) {
                $cek    = Absensi::where('seminar_id', $seminar->id)->where('tgl_absen', Date('Y-m-d'))->first();
                if (!$cek) {
                    $absen = new Absensi();
                    $absen->seminar_id = $seminar->id;
                    $absen->kode_event = $seminar->kode_event;
                    $absen->tgl_absen  = Date('Y-m-d');
                    $absen->save();
                    $event = Event::where('kode_event', $seminar->kode_event)->first();
                    if ($event) {
                        $cw = ReplaceArray($seminar, $event->cw_absen);
                        $kirrim = Whatsapp::send(['token' => $token, 'phone' => $seminar->phone, 'message' => $cw]);
                        if ($seminar->ref) {
                            $ref_seminar = Seminar::where('phone', $seminar->ref)->first();
                            if ($ref_seminar) {
                                // Log::debug($ref_seminar);
                                $cw_ref_data = ['phone' => $seminar->phone, 'ref_panggilan' => $ref_seminar->panggilan ?? $ref_seminar->nama, 'ref_sapaan' => $ref_seminar->sapaan, 'nama' => $seminar->nama];
                                $cw_ref      = ReplaceArray($cw_ref_data, $event->cw_absen_ref);
                                $d = Whatsapp::send(['token' => 3, 'phone' => $ref_seminar->phone, 'message' => $cw_ref]);
                                // Log::info($d);
                            }
                        }
                    }
                }
            }
        } else if ($type == 'buttons_response') {
            $tb         = "zu" . $device->user_id . "_antrians";
            $btnid      = $cal->selectedButtonId;
            $btnText    = $cal->selectedDisplayText;
            $this->responseButtonMessage($btnid, $cal, $tb, $btnText);
        }

        // save respon
        Warespon::init($tb_res);
        $tbres = new Warespon();;
        $tbres = $tbres->setTable($tb_res);
        $cek   = $tbres->where('device_id', $device_id)->where('phone', $phone)->first();
        if (!$cek) {
            $tbres->phone = $phone;
            $tbres->device_id = $device_id;
            $tbres->name  = $cal->name ?? '';
            $tbres->type  = $type;
            $tbres->save();
        }
    }

    protected function responseButtonMessage($param, $resWA, $tb_name, $btnText)
    {
        // Log::info('responseButtonMessage', [$param, $resWA, $tb_name, $btnText]);
        $id_pesan = $param[0] ?? null;
        $nomor_btn   = $param[1] ?? null;
        $check_reply = $param[2] ?? null;
        $response_text = $param[3] ?? null;
        $update  =  true;
        // Log::info('param', [$param, $resWA, $tb_name, $btnText]);
        if ($check_reply == 1) {
            // Ambil pesan-nya
            $antrian = DB::table($tb_name)->where('id', $id_pesan)->first();
            if (!$antrian) {
                Log::error("Webhook-btn: {$tb_name} id:{$id_pesan} tidak ditemukan");
                return;
            }
            // Jika sudah pilih maka kirim pesan balasan dari coll next_reply
            if (!is_null($antrian->btn_select_text) || !is_null($antrian->btn_select_id)) {
                // Jika next_reply kosong GAK USAH DILANJUTKAN
                if (is_null($antrian->next_reply)) {
                    return false;
                } else {
                    $response_text = $antrian->next_reply;
                }

                // ubah ke false agar gak diupdate lagi jawannya
                $update = false;
            }
        }

        if ($update) {
            DB::table($tb_name)->where('id', $id_pesan)->update([
                'btn_select_id' => $nomor_btn,
                'status' => 2,
                'btn_select_text' => $btnText
            ]);
        }


        $data_pesan = [
            "token" => $resWA->token,
            "phone" => $resWA->server_phone,
            "message" => $response_text,
        ];
        $kirim = Whatsapp::send($data_pesan);
    }
}
