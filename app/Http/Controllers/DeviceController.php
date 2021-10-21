<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Helpers\Whatsapp;
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
        
        $title = "List Device";
        return view('whatsapp.device',compact('device','title'));
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

    public function qrcode(Request $request)
    {
        return Device::where('id',$request->id)->first();        
    }
    
}
