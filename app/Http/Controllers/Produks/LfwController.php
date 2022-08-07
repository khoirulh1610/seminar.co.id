<?php

namespace App\Http\Controllers\Produks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transaksi_lfw;
use App\Models\lfw;
use App\Helpers\Whatsapp;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LfwController extends Controller
{
    public function daftar(Request $request)
    {
        $val = transaksi_lfw::where('phone',$request->phone)->first();
        if($val){
           //return Redirect::back()->withErrors(['msg' => 'Sudah Pernah Daftar, hubungi admin 6289514010645']);
            return redirect()->back()->with('success', 'Sudah Pernah Daftar, hubungi admin 6289514010645');   
        }

        $prov = Provinsi::where('id',$request->provinsi)->first();
        $kota = Kabupaten::where('id',$request->kota)->first();

        $in = transaksi_lfw::insert([
            'paket_id' => $request->level,
            'username'=> $request->username,
            'nama'=> $request->name,
            'sapaan'=> $request->sapaan,
            'panggilan'=> $request->panggilan,
            'phone'=> $request->phone,
            'email'=> $request->email,
            'bank'=> $request->bank ?? '',
            'no_rek'=> $request->no_rek ?? '',
            'provinsi' => $prov->name ?? '',
            'kodepos' => $request->kodepos ?? '',
            'kota' => $kota->full_name ?? '',
            'alamat'=> $request->alamat ?? '',
            'ktp'=> $request->ktp ?? '',
            'jkel'=> $request->jenis_kelmain ?? '',
            'created_at' => Carbon::now()
        ]);

        $paket = lfw::where('id',$request->level)->first();

        if($in){
            $cek = transaksi_lfw::where('phone', $request->phone)->first();
            $pesan = $cek->msg_tagihan;
            $phone = $cek->phone;

        $idterakhir = transaksi_lfw::orderBy('id', 'desc')->first();
        $idnya = $idterakhir->id + 1;

        $harga = $paket->harga + $idnya;
        $nominal = "Rp " . number_format($harga,0,',','.');

$pesan='
👍Selamat *'.$request->sapaan.'* *'.$request->panggilan.'*

Anda berhasil Registrasi untuk menjadi Member Live For Win

Dengan Paket *'.$paket->paket.'*
Silakan Transfer sejumlah *'.$nominal.',-*

Ke Rekening BCA 0888349777
Atas Nama: PT Graha Sukses Mendunia


Setelah Transfer Mohon konfirmasi Bukti Transfer ke Nomor Whatsapp ini
';
            $resWA = Whatsapp::send([
                'token' => 7,
                'phone' => $request->phone,
                'message' => $pesan
            ]);
        }

        if($resWA){
            $up = transaksi_lfw::where('phone',$request->phone)->update([
                'unik' => $idnya,
                'bayar' => $harga,
                'bayar_rp' => $nominal,
                'msg_tagihan' =>$pesan
            ]);
            $resWAG = Whatsapp::send([
                'token' => 7,
                'phone' => '120363027570714751@g.us',
                'message' => $pesan
            ]);
            Log::info([$resWA, $resWAG]);
        }

        
         return redirect()->back()->with('success', 'Selamat anda telah terdaftar, silahkan cek Whatsapp anda.'); 
    }
}
