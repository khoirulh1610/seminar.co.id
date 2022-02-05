<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Whatsapp;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Device;
use App\Models\Event;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AntrianController extends Controller
{
    public function antrian()
    {
        $data = file_get_contents("php://input");
        Log::info($data);
        if ($data) {
            try {
                $a = json_decode($data);
                $token = $a->token;
                $device = Device::where('id', $token)->first();
                if ($device) {
                    $tb = "zu" . $device->user_id . "_antrians";
                    Log::info("Cek DV Pesan ". $tb);                    
                    $Kirimpesan = DB::table($tb)->Where('id', $a->refid)->first();                    
                    if ($Kirimpesan) {
                        Log::info("upadate Pesan");
                        $Kirimpesan = DB::table($tb)->Where('id', $a->refid)->update([
                            "messageid"=>$a->messageid ?? null,
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
        $data = file_get_contents("php://input");
        Log::alert($data);
        $cal = json_decode($data);
        $phone = $cal->phone ?? false;
        $message = $cal->message ?? '';
        $token = $cal->token ?? 0;
        if($phone && strtolower($message)=='hadir'){
            $seminar = Seminar::where('phone',$phone)->first();            
            if($seminar){
                $cek   = Absensi::where('seminar_id',$seminar->id)->where('tgl_absen',Date('Y-m-d'))->first();
                if(!$cek){
                    $absen = new Absensi();
                    $absen->seminar_id = $seminar->id;
                    $absen->kode_event = $seminar->kode_event;
                    $absen->tgl_absen  = Date('Y-m-d');
                    $absen->save();
                    $event = Event::where('kode_event',$seminar->kode_event)->first();
                    if($event){
                        $cw = ReplaceArray($seminar,$event->cw_absen);
                        $kirrim = Whatsapp::send(['token'=>$token,'phone'=>$seminar->phone,'message'=>$cw]);
                        if($seminar->ref){
                            $ref_seminar = Seminar::where('phone',$seminar->ref)->first();                        
                            if($ref_seminar){
                                // Log::debug($ref_seminar);
                                $cw_ref_data = ['phone'=>$seminar->phone,'ref_panggilan'=>$ref_seminar->panggilan ?? $ref_seminar->nama,'ref_sapaan'=>$ref_seminar->sapaan,'nama'=>$seminar->nama];
                                $cw_ref      = ReplaceArray($cw_ref_data,$event->cw_absen_ref);
                                $d = Whatsapp::send(['token'=>3,'phone'=>$ref_seminar->phone,'message'=>$cw_ref]);
                                // Log::info($d);
                            }
                        }
                    }
                }
            }
        }
    }
}
