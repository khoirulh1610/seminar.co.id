<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Carbon\Carbon;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Auth.register');        
    }

    public function save(Request $request)
    {        
        $request->validate([
            'email'    => 'required',
            'password' => 'required'
        ]);
        $cek = User::where('email',$request->email)->first();
        if($cek){
            return redirect()->back()->with('info','Email sudah Terdaftar');
        }else{
            $user               = new User();
            $user->sapaan       = $request->sapaan;
            $user->name         = $request->nama;
            $user->panggilan    = $request->panggilan;
            $user->phone        = $request->phone;
            $user->email        = $request->email;
            $user->password     = Hash::make($request->password);
            $user->save();
        }
        return redirect('/login');
    }
}
