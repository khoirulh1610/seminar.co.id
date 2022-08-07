<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()) {
            return redirect('/dashboard');
        }
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|string', //VALIDASI KOLOM USERNAME
            'password'  => 'required|string|min:6',
        ]);

        $email      = $request->email;
        $user       = User::firstWhere('email', $email);
        if(!$user){
            $peserta    = Seminar::firstWhere('email', $email);
            $event      = Event::firstWhere('kode_event', $peserta->kode_event);
            $cek_user   = User::firstWhere('phone', $peserta->phone);
            if(!$cek_user){
                // craete user from seminar
                $user            = new User();
                $user->sapaan    = $peserta->sapaan;
                $user->panggilan = $peserta->panggilan;
                $user->nama      = $peserta->nama;
                $user->email     = strtolower($peserta->email);
                $user->phone     = $peserta->phone;
                $user->profesi   = $peserta->profesi;
                $user->prov_id   = $peserta->prov_id;
                $user->provinsi  = $peserta->provinsi;
                $user->kota_id   = $peserta->kota_id;
                $user->kota      = $peserta->kota;
                $user->b_tanggal = $peserta->b_tanggal;
                $user->b_bulan   = $peserta->b_bulan;
                $user->b_tahun   = $peserta->b_tahun;
                $user->kode_ref  = Str::random(8);
                $user->password  = Hash::make('12345678');
                $user->role_id   = 4;
                $user->brand     = $event->produk ?? $event->brand ?? ''; 
                $user->save();

                // Cek Device User Baru
                $cek_device         = Device::where('user_id', $user->id)->first();
                if(!$cek_device){
                    $device             = new Device();
                    $device->user_id    = $user->id;
                    $device->phone      = $user->phone;
                    $device->label      = Str::random(10);
                    $device->server_id  = '3';
                    $device->mode       = 'md';
                    $device->created_at = Carbon::now();
                    $device->updated_at = Carbon::now();
                    $device->save();
                }
            }else{
                return redirect()->back()->with('error', 'Nomor ' . $cek_user->phone . $cek_user->email. ' sudah terdaftar di Seminar');
            }
        }else{
            // Cek Device User Lama
            $cek_device_ul           = Device::where('user_id', $user->id)->first();
            if(!$cek_device_ul){
                $device              = new Device();
                $device->user_id     = $user->id;
                $device->phone       = $user->phone;
                $device->label       = Str::random(10);
                $device->server_id   = '3';
                $device->mode        = 'md';
                $device->created_at  = Carbon::now();
                $device->updated_at  = Carbon::now();
                $device->save();
            }

            // Update Data Brand User Sesuai dengan seminar yang diikuti
            $cek    = Seminar::firstWhere('email', $email);
            $event  = Event::firstWhere('kode_event');
            if ($cek) {
                $update = $user->update([
                    'brand' => $event->produk ?? $event->brand ?? '',
                ]);
            }
        }

        // $cek1   = User::where('email', $email)->first();
        // if (!$cek1) {
        //     $cek_seminar = Seminar::where('email', $email)->first();
        //     if ($cek_seminar) {
        //         $cek_user   = User::where('phone', $cek_seminar->phone)->first();
        //         $event      = Event::where('brand', 'lfw')->orWhere('produk', 'lfw')->pluck('kode_event');
        //         $cek        = Seminar::where('email', $email)->whereIn('kode_event', $event)->first();
        //         if ($cek_user) {
        //             return redirect()->back()->with('error', 'Nomor ' . $cek_seminar->phone . ' yang didaftarkan di seminar, Sudah masuk sebagai user dengan email ' . $cek_user->email);
        //         } else {
        //             // craete user from seminar
        //             $user            = new User();
        //             $user->sapaan    = $cek_seminar->sapaan;
        //             $user->panggilan = $cek_seminar->panggilan;
        //             $user->nama      = $cek_seminar->nama;
        //             $user->email     = strtolower($cek_seminar->email);
        //             $user->phone     = $cek_seminar->phone;
        //             $user->profesi   = $cek_seminar->profesi;
        //             $user->prov_id   = $cek_seminar->prov_id;
        //             $user->provinsi  = $cek_seminar->provinsi;
        //             $user->kota_id   = $cek_seminar->kota_id;
        //             $user->kota      = $cek_seminar->kota;
        //             $user->b_tanggal = $cek_seminar->b_tanggal;
        //             $user->b_bulan   = $cek_seminar->b_bulan;
        //             $user->b_tahun   = $cek_seminar->b_tahun;
        //             $user->kode_ref  = Str::random(8);
        //             $user->password  = Hash::make('12345678');
        //             $user->role_id   = 4;
        //             if($cek){
        //                 $user->brand    = 'LFW';
        //             }
        //             $user->save();
        //         }
        //     }

        //     // $user               = User::where('email', $cek_seminar->email)->where('phone', $cek_seminar->phone)->first();
        //     // if($cek) {
        //     //     $update = $user->update([
        //     //         'brand' => 'LFW',
        //     //     ]);
        //     // }
        //     $cek_device         = Device::where('user_id', $user->id)->first();
        //     if(!$cek_device){
        //         $device             = new Device();
        //         $device->user_id    = $user->id;
        //         $device->phone      = $user->phone;
        //         $device->label      = Str::random(10);
        //         $device->server_id  = '3';
        //         $device->mode       = 'md';
        //         $device->created_at = Carbon::now();
        //         $device->updated_at = Carbon::now();
        //         $device->save();
        //     }
        // }else{
        //     $cek_device_ul           = Device::where('user_id', $cek1->id)->first();
        //     if(!$cek_device_ul){
        //         $device              = new Device();
        //         $device->user_id     = $cek1->id;
        //         $device->phone       = $cek1->phone;
        //         $device->label       = Str::random(10);
        //         $device->server_id   = '3';
        //         $device->mode        = 'md';
        //         $device->created_at  = Carbon::now();
        //         $device->updated_at  = Carbon::now();
        //         $device->save();
        //     }

        //     $event  = Event::where('brand', 'lfw')->orWhere('produk', 'lfw')->pluck('kode_event');
        //     $cek    = Seminar::where('email', $email)->whereIn('kode_event', $event)->first();
        //     if ($cek) {
        //         $update = $cek1->update([
        //             'brand' => 'LFW',
        //         ]);
        //     }
        // }

        

        // if ($cek1->status !== 1) {
        //     return redirect()->back()->with('error', 'Mohon maaf email ' . $email . ' tidak diijinkan login, Silahkan hubungi admin');
        // }

        //TAMPUNG INFORMASI LOGINNYA, DIMANA KOLOM TYPE PERTAMA BERSIFAT DINAMIS BERDASARKAN VALUE DARI PENGECEKAN DIATAS
        $login = [
            'email'     => $email,
            'password'  => $request->password
        ];

        //LAKUKAN LOGIN
        if (auth()->attempt($login)) {
            return redirect('/dashboard');
        }
        //JIKA SALAH, MAKA KEMBALI KE LOGIN DAN TAMPILKAN NOTIFIKASI 
        return redirect()->back()->with('error', 'Email / Password salah! ' . $request->email);
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect('/login');
    }
}
