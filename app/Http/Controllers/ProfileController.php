<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminar;
use App\Models\Brand;
use Auth,Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profile    = User::where('id',Auth::id())->get();
        $peserta    = Seminar::where('ref',Auth::user()->phone)->count();
        return view('profile.profile',compact('profile','peserta'));
    }

    public function edit(Request $request)
    {
        $edit   = User::where('id',Auth::id())->first();
        if($request->id){
            $edit   = User::where('id',$request->id)->first();
        }
        $brand  = Brand::get();
        return view('profile.edit',compact('edit','brand'));
    }

    public function save(Request $request)
    {
        $profile    = User::where('id',Auth::id())->first();
        if($request->id){
            $profile   = User::where('id',$request->id)->first();
        }
        $profile->sapaan    = $request->sapaan;
        $profile->panggilan = $request->panggilan;
        $profile->phone     = $request->phone;
        $profile->nama      = $request->nama;
        $profile->no_rek    = $request->no_rek;
        $profile->bank      = $request->bank;
        $profile->email     = $request->email;
        if($request->password){
            $profile->password  = Hash::make($request->password);
        }
        $profile->brand     = $request->brand;
        $profile->kode_ref  = $request ->referal;
        $profile->phone     = $request ->phone;
        $profile->email     = $request ->email;
        if($request ->role_id){
            $profile->role_id   = $request ->role_id;
        }
        $profile->save();
        return redirect()->back();
    }
}
