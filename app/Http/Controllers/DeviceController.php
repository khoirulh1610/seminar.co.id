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
        $device = Device::where('user_id',Auth::id())->get();
        $device_id = $request->id;
        return view('whatsapp.device',compact('device','device_id'));
    }

    public function start(Request $request)
    {        
        $device = Device::where('user_id',$request->id)->first();
        if($device){
            return Whatsapp::start(["instance"=>(String)$device->id]);
        }        
    }

    public function scanQr(Request $request)
    {
        $device = Device::where('user_id',$request->id)->first();
        // return $device;
        if($device){
            if($device->server_id>=3){
                $h = [  "status"    => true,
                        "qrcode"    => $device->barcode
                    ];
                    return $h;
            }else{
                $data = ["req"=>"qrcode"];    
                // return ApiWa($device->id,$data);                      
                return response()->json(json_decode(ApiWa($device->id,$data)));
            }
            
        }else {
            return ["msg"=>"ERROR"];
        }
    }

    public function logout(Request $request)
    {        
        $device = Device::where('id',$request->id)->first();
        if($device){
            $device->phone = "";
            $device->name = "";
            $device->pic_url = "";
            $device->save();
            $data = ["req"=>"delete","device_id"=>$device->id];           
            return response()->json(json_decode(ApiWa($device->id,$data)));
        }  
    }
}
