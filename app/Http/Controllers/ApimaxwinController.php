<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Notifikasi;
use App\Helpers\Whatsapp;
use Illuminate\Support\Facades\DB;
use App\Models\Seminar;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Access;
use App\Models\Event;
use App\Models\Bank;
use App\Models\User;
use App\Models\Setting;
use App\Mail\RegistrasiMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\RegisterMailJob;
use App\Models\Absensi;
use App\Models\Notifikasi as WaNotif;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DataTables;

class ApimaxwinController extends Controller
{
    //
    public function kirim($phone, $pesan)
    {
        # code... 
        // $messg = json_decode($pesan);
        // $resWA = Whatsapp::send([
        //     'token' => 35,
        //     'phone' => $phone,
        //     'message' => $messg
        // ]);

        $in = DB::table('zu15057_antrians')->insert([
            'user_id'       => 15057,
            'device_id'     => 73,
            'phone'         => $phone,
            'type_message'  => 'text',
            'message'       => $pesan,
            'status'        => 1,
            'type'          => 'wa',
            'pause'         => 1,
            'retry'         => 0,
            'priority'      => 1,
            'created_at'     => Carbon::now()

        ]);
    }

    public function sender(Request $request)
    {
        # code...
        $phone      = $request->phone;
        $pesan      = $request->pesan;

        //$messg = json_decode($pesan);
        $resWA = Whatsapp::send([
            'token' => 73,
            'phone' => $phone,
            'message' => $pesan
        ]);
    }


    public function kode_agen($phone, $kode_agen)
    {
        # code...
        $cek = User::where('phone', $phone)->update([
            'kode_ref' => $kode_agen
        ]);
        Log::debug("Update KodeRef:", ['phone' => $phone, 'kode_agen' => $kode_agen]);
    }

    public function seminar($phone)
    {
        # code...
        $data = Seminar::where('ref', $phone)
            // ->orwhere('kode_event','Mjztg')
            // ->orwhere('kode_event','pIXYB')
            ->where('kode_event', 'bNeKp')
            // ->orwhere('kode_event','QDLZF')
            //->where('kode_event','rM519')
            ->orderBy('id', 'DESC')->get();
        return Datatables::of($data)->make(true);
    }

    public function absen($phone)
    {
        # code...
        $ref = $phone ?? '-';
        $kode_event = 'bNeKp';
        $data  = DB::select("select b.*,a.created_at masuk from absensis a left join seminars b on a.seminar_id=b.id where a.kode_event='$kode_event' and b.ref = $ref ORDER BY a.id DESC");
        return Datatables::of($data)->make(true);
    }

    public function tidakabsen($phone)
    {
        # code...
        $ref = $phone;
        $kode_event = 'bNeKp';
        $data  = DB::select("select b.*,a.created_at masuk from absensis a left join seminars b on a.seminar_id=b.id where a.kode_event='$kode_event' and b.ref = $ref ORDER BY a.id DESC");
        return Datatables::of($data)->make(true);
    }

    public function ceklink($phone)
    {
        # code...
        $link = Seminar::where('kode_event', 'bNeKp')
            ->where('phone', $phone)
            ->first();

        if ($link) {
            return $link->phone;
        }
    }
}
