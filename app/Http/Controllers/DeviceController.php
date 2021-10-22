<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Helpers\Whatsapp;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Str;
use Auth;

class DeviceController extends Controller
{
    // Device
    public function device(Request $request)
    {
        if(Auth::user()->role_id==1){
            $device = Device::get();
        }else{
            $device = Device::where('user_id',Auth::id())->get();
        }
        $user = User::where('role_id','<=',3)->get();
        $brand = Brand::get();
        $title = "List Device";
        return view('whatsapp.device',compact('device','title','user','brand'));
    }

    public function show(Request $request)
    {
        $device = Device::where('id',$request->id)->first();
        $title = "Whatsapp Service";
        return view('whatsapp.show',compact('device','title'));
    }

    public function start(Request $request)
    {        
        $device = Device::where('id',$request->id)->first();
        if($device){
            return Whatsapp::start(["instance"=>(String)$device->id]);
        }        
    }

    public function baru(Request $request)
    {
        $device             = new Device;
        $device->device_key = Str::random(10);;
        $device->user_id    = $request->user;
        $device->brand      = $request->brand;
        $device->nama       = $request->nama ?? '';
        $device->save();
        // return $device;
        return redirect('/device/device');
    }

    public function qrcode(Request $request)
    {
        return Device::where('id',$request->id)->first();        
    }
    
    public function delete(Request $request)
    {
        $device = Device::where('id',$request->id)->first();
        if($device){
            $logout = Whatsapp::logout(["instance"=>(String)$device->id]);
            $device = Device::where('id',$request->id)->delete();
        }
        return redirect('/device/device');
    }
}
