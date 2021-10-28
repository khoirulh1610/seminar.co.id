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
        $brand      = Brand::where('status',1)->get();        
        return view('profile.profile',compact('brand'));
    }

    public function edit(Request $request)
    {
        $edit       = User::where('id',Auth::id())->first();
        if($request->id){
            $edit   = User::where('id',$request->id)->first();
        }
        $brand      = Brand::get();
        return view('profile.edit',compact('edit','brand'));
    }

    public function save(Request $request)
    {
        $profile        = User::where('id',Auth::id())->first();
        if($request->id){
            $profile    = User::where('id',$request->id)->first();
        }

        // if($request->foto){
        //     $file                   = $request->file('foto');
        //     $filepath               = 'uploads/';
        //     $fileName               = 'file_name'.time().".".$file->getClientOriginalExtension();
        //     $getClientOriginalName  = $file->getClientOriginalName();
        //     $file->move('uploads/',$fileName);
        //     $filename               = url('uploads/'.$fileName);
        //     $path_file              = 'uploads/'.$fileName;
        //     $profile->foto_profile  = $filename;
        // }
        $profile->foto_profile  = $request->link;
        $profile->sapaan        = $request->sapaan;
        $profile->panggilan     = $request->panggilan;
        $profile->phone         = $request->phone;
        $profile->nama          = $request->nama;
        $profile->bank          = $request->bank;
        $profile->rek_bank      = $request->rek_bank;
        $profile->email         = $request->email;
        if($request->password){
            $profile->password  = Hash::make($request->password);
        }
        $profile->brand         = $request->brand;
        $profile->kode_ref      = $request->referal;
        $profile->phone         = $request ->phone;
        $profile->email         = $request ->email;
        if($request ->role_id){
            $profile->role_id   = $request ->role_id;
        }

        $profile->save();
        return redirect('/profile');
    }
}
