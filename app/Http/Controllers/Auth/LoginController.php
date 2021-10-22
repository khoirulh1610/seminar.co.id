<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminar;
use Auth, Hash;
use Str;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()){
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

        $email = $request->email;
        $cek1 = User::where('email',$email)->first();
        if(!$cek1){
            $cek_seminar = Seminar::where('email',$email)->first();
            if($cek_seminar){
                $cek_user = User::where('phone',$cek_seminar->phone)->first();
                if($cek_user){
                    return redirect()->back()->with('error' ,'Nomor '.$cek_seminar->phone.' yang didaftarkan di seminar, Sudah masuk sebagai user dengan email '.$cek_user->email); 
                }else{
                    // craete user from seminar
                    $user = new User();
                    $user->sapaan    = $cek_seminar->sapaan;
                    $user->panggilan = $cek_seminar->panggilan;
                    $user->nama      = $cek_seminar->nama;
                    $user->email     = strtolower($cek_seminar->email);
                    $user->phone     = $cek_seminar->phone;
                    $user->profesi   = $cek_seminar->profesi;
                    $user->prov_id   = $cek_seminar->prov_id;
                    $user->provinsi  = $cek_seminar->provinsi;
                    $user->kota_id   = $cek_seminar->kota_id;
                    $user->kota      = $cek_seminar->kota;
                    $user->b_tanggal = $cek_seminar->b_tanggal;
                    $user->b_bulan   = $cek_seminar->b_bulan;
                    $user->b_tahun   = $cek_seminar->b_tahun;
                    $user->kode_ref  = Str::random(8);
                    $user->password  = Hash::make('123456');
                    $user->role_id   = 4;                    
                    $user->save();
                }
            }
        }

        if($cek1->status!==1){
            return redirect()->back()->with('error' ,'Mohon maaf email '.$email.' tidak diijinkan login, SIlahkan hubungi admin'); 
        }
        
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
        return redirect()->back()->with('error' ,'Email / Password salah! '. $request->email);
    }

    public function logout(Request $request)
    {
        if(Auth::user()){
            Auth::logout();
        }
        return redirect('/login');
    }
}
