<?php

namespace App\Http\Controllers;

use App\Helpers\HelperZoom;
use App\Helpers\Notifikasi;
use App\Helpers\Whatsapp;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\lfw;
use App\Models\transaksi_lfw;
use App\Models\Notifikasi as WaNotif;
use App\Models\Event;
use App\Models\Lfwuser;
use App\Models\Seminar;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\TransaksiSeminar;
use App\Models\User;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DaftarflwController extends Controller
{
    //
    public function index()
    {
        # code...
        return view('DaftarFLW.flw');
    }

    public function save(Request $request)
    {
        # code...
        // $cek = TransaksiSeminar::where('id', $id)->first();
        // $pesan = $cek->msg_tagihan;
        // $phone = $cek->phone;
        // $resWA = Whatsapp::send([
        //     'token' => 35,
        //     'phone' => $phone,
        //     'message' => $pesan
        // ]);

    }

    public function daftar(Request $request)
    {
        # code...
        $id = $request->lev;
        $cek = lfw::where('id',$id)->first();
        
        return view('DaftarFLW.daftar', compact('cek'));
    }

    public function daftarBaru(Request $request)
    {
        $event      = Event::where('kode_event', 'LifeForWin')->first();
        return view('DaftarFLW.daftarBaru', compact('event'));
    }

    public function daftarStore(Request $request)
    {
        $nama           = $request->nama;
        $email          = strtolower($request->email);
        $prov_id        = $request->provinsi;
        $kota_id        = $request->kota;
        $phone          = $request->phone;
        $sapaan         = $request->sapaan;
        $panggilan      = $request->panggilan;
        $profesi        = $request->profesi;
        $jabatan        = $request->jabatan;
        $bidang_usaha   = $request->bidang_usaha;
        $kode_event     = $request->kode_event;
        $username       = strtoupper($request->username);
        $kota           = DB::table('kabupatens')->where('id', $kota_id)->first()->full_name ?? DB::table('kabupatens')->where('id', $kota_id)->first()['full_name'] ?? '';
        $provinsi       = DB::table('provinsis')->where('id', $prov_id)->first()->name ?? DB::table('provinsis')->where('id', $prov_id)->first()['name'] ?? '';
        $cekUserLfw     = Lfwuser::where('username', $username)->first();
        $event          = Event::where('kode_event', $request->kode_event)->first();
        $cekPeserta     = Seminar::where('email', $request->email)->where('phone', $request->phone)->where('kode_event', $request->kode_event)->first();
        $ref            = $request->ref ?? 'admin';
        $referal        = User::where('kode_ref', $ref)->orWhere('phone', $ref)->first();
        $harga          = $event->harga ?? 0;
        $unix           = rand(1, 999) ?? 0;
        $total          = ($harga > 0 ? $harga + $unix : 0);
        $join_zoom      = $event->meeting_id ? (HelperZoom::join($event->zoom_id, $sapaan, $panggilan . ', ' . $kota, $email, $event->meeting_id) ?? $event->link_zoom ?? null) : null;
        $array_user     = ["nama" => $nama, "email" => $email, "total" => 'Rp. ' . number_format($total, 0), "phone" => $phone, "provinsi" => $provinsi, "sapaan" => $sapaan, "tgl_seminar" => $event->tanggal, "panggilan" => $panggilan, "profesi" => $profesi, "ref" => $ref, "kota" => $kota, 'join_zoom' => $join_zoom];
        $message        = ReplaceArray($array_user, $event->cw_register) ?? null;
        $message2       = ReplaceArray($array_user, $event->cw_register2) ?? null;
        if(!$cekPeserta){
            if($cekUserLfw){
                $seminar                = new Seminar();
                $seminar->sapaan        = $sapaan;
                $seminar->panggilan     = $panggilan;
                $seminar->nama          = $nama;
                $seminar->email         = $email;
                $seminar->phone         = $phone;
                $seminar->profesi       = $profesi;
                $seminar->jabatan       = $jabatan;
                $seminar->bidang_usaha  = $bidang_usaha;
                $seminar->prov_id       = $prov_id;
                $seminar->provinsi      = $provinsi;
                $seminar->kota_id       = $kota_id;
                $seminar->kota          = $kota;
                $seminar->harga         = $harga;
                $seminar->unix          = $unix;
                $seminar->total         = $total;
                $seminar->status        = 0;
                $seminar->tgl_seminar   = $event->tgl_event;
                $seminar->kode_event    = $kode_event;
                $seminar->fee_referral  = $request->fee_referral ?? 0;
                $seminar->fee_admin     = $request->fee_admin ?? 0;
                $seminar->b_tanggal     = $request->tanggal;
                $seminar->b_bulan       = $request->bulan;
                $seminar->b_tahun       = $request->tahun;
                $seminar->username      = $cekUserLfw->username;
                $seminar->ref           = $cekUserLfw->phone;
                $seminar->message       = $message;
                $seminar->message2      = $message2;
                $seminar->created_at    = Carbon::now();
                $seminar->updated_at    = Carbon::now();
                // Ambil data terakhir dari ikut event-nya
                $peserta                = Seminar::where('phone', $request->phone)->orderBy('id', 'DESC')->first();
                $ref_exp                = $peserta ? $peserta->ref_exp : null;
                $exp_produk_peserta     = Carbon::parse($ref_exp)->second(0);
                $now                    = Carbon::now();
                $produkku               = $event->product;

                // jika tgl exp_produk_peserta sudah lewat, maka atur ulang
                if ($exp_produk_peserta->lt($now)) {
                    // Bisa ganti refferalnya
                    $seminar->ref = $referal->phone ?? $ref ?? null;
                    // Atur ulang tgl exp_produk_peserta jika ada
                    if ($produkku) {
                        $expRef = $produkku->exp_referral;
                        if ($expRef !== null) {
                            // Ganti ke baru
                            $seminar->ref_exp = Carbon::now()->addMonths($expRef);
                        }
                    }
                } else {
                    // Tidak bisa ganti refferalnya (yang lama dipakai)
                    $seminar->ref = $referal->phone ?? $peserta->ref ?? $ref  ?? null;
                    $seminar->ref_exp = $peserta->ref_exp;
                }
                // dd($seminar);
                $seminar->save();

                // Notifikasi ke peserta                 
                $WaNotif = new WaNotif();
                $WaNotif->kode_event = $request->kode_event;
                $WaNotif->phone = $request->phone;
                $WaNotif->notif = $request->message;
                $WaNotif->judul = "Notifikasi user daftar";
                $WaNotif->nama  = $request->nama;
                $WaNotif->save();

                // $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message,"engine"=>$event->notifikasi,"delay"=>0]);                    
                // if($message2){
                //     $notif2                 = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message2,"engine"=>$event->notifikasi,"delay"=>0]);
                // }
                // $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>'120363023657414562@g.us',"message"=>$message,"engine"=>$event->notifikasi,"delay"=>1]);

                $notif1 =  Whatsapp::send([
                    "token"     => $event->device_id,
                    "phone"     => $request->phone,
                    "message"   => $message
                ]);
                if ($message2) {
                    $notif2 =  Whatsapp::send([
                        "token"     => $event->device_id,
                        "phone"     => $phone,
                        "message"   => $message2
                    ]);
                }

                // web Notif
                $data = [
                    "title" => "Pendaftar Seminar " . $kode_event,
                    "body" => "Nama : " . $nama . " Email : " . $email
                ];
                $webnotif = Notifikasi::fcmAll($data);
                // Notifikasi Ke Pengundang
                if ($referal) {
                    if ($event->cw_referral) {
                        $jumlah_undangan = Seminar::where('ref', $referal->phone)->where('kode_event', $kode_event)->count();
                        $ary2            = [
                            "nama"                  => $nama,
                            "email"                 => $email,
                            "total"                 => number_format($total, 0),
                            "phone"                 => $phone,
                            "provinsi"              => $provinsi,
                            "sapaan"                => $sapaan,
                            "profesi"               => $profesi,
                            "tgl_seminar"           => $event->tanggal,
                            "panggilan"             => $panggilan,
                            "ref"                   => $ref,
                            "kota"                  => $kota,
                            "jumlah_undangan"       => $jumlah_undangan,
                            "pengundang_sapaan"     => $referal->sapaan ?? null,
                            "pengundang_nama"       => $referal->nama ?? null,
                            "pengundang_panggilan"  => $referal->panggilan ?? null,
                        ];
                        $cw_referral            = ReplaceArray($ary2, $event->cw_referral);
                        $WaNotif                = new WaNotif();
                        $WaNotif->phone         = $ref;
                        $WaNotif->notif         = $cw_referral;
                        $WaNotif->kode_event    = $kode_event;
                        $WaNotif->judul         = "Notifikasi user daftar ke pengundang";
                        $WaNotif->nama          = $referal->nama ?? null;
                        $WaNotif->save();
                        $notif4 =  Whatsapp::send([
                            "token" => $event->device_id,
                            "phone" => $referal->phone,
                            "message" => $cw_referral
                        ]);
                        $notif5 =  Whatsapp::send([
                            "token" => $event->device_id,
                            "phone" => $event->group_info,
                            "message" => '*Info Group :*' . $cw_referral
                        ]);
                    }
                }
                return redirect('/daftar/lfw')->with('store', 'Selamat anda terdaftar seminar '.$event->title.' dengan email '.$request->email.' dan nomor '.$request->phone);
            }else{
                return redirect()->back()->with('wrongUName', 'Maaf! Username yang anda masukkan tidak tersedia.');
            }
        }else{
            return redirect()->back()->with('isFound', 'Anda sudah terdaftar seminar '.$event->title.' dengan email '.$request->email.' dan nomor '.$request->phone);
        }
    }


    public function absenLfw(Request $request)
    {
        $event      = Event::where('kode_event', 'LifeForWin')->first();
        return view('DaftarFLW.absenLfw', compact('event'));
    }

    public function absenStore(Request $request)
    {
        $phone      = preg_replace('/^0/', '62', $request->phone);
        $peserta    = Seminar::where('phone', $phone)->first();
        $event      = Event::where('kode_event', $request->kode_event)->first();
        if($peserta){
            $cekAbsensi     = Absensi::where('seminar_id', $peserta->id)->first();
            if(!$cekAbsensi){
                # Lakukan Absensi Kehadiran
                $hadir = Absensi::create([
                    'seminar_id'    => $peserta->id,
                    'kode_event'    => $event->kode_event,
                    "tgl_absen"     => Date('Y-m-d')
                ]);
                Whatsapp::send(["token" => $event->device_id, "phone" => $peserta->phone, "message" => ReplaceArray($peserta, $event->cw_absen)]);
                return redirect()->back()->with('Success', 'Selamat anda berhasil absen dengan data Email : '.$peserta->email.' dan Nomor Handphone : '.$phone);
            }else{
                return redirect()->back()->with('already', 'Mohon maaf, Anda sudah absen pada seminar ini.');
            }
        }else{
            return redirect()->back()->with('notRegistered', 'Mohon maaf, Anda Belum Terdaftar Seminar.');
        }
    }

    public function rangking()
    {
        $event      = Event::where('kode_event', 'LifeForWin')->first();
        $peserta    = Seminar::where('kode_event', $event->kode_event)->get();
        $absen      = Absensi::where('kode_event', $event->kode_event)->get();
        $rangking   = [];
        foreach ($peserta as $key => $value) {
            $rangking[$key]['nama'] = $value->nama;
            $rangking[$key]['email'] = $value->email;
            $rangking[$key]['phone'] = $value->phone;
            $rangking[$key]['total'] = 0;
            foreach ($absen as $key2 => $value2) {
                if($value2->seminar_id == $value->id){
                    $rangking[$key]['total'] += 1;
                }
            }
        }
        $rangking = collect($rangking)->sortByDesc('total');
        return view('DaftarFLW.rangking', compact('rangking', 'event'));
    }
   
}
