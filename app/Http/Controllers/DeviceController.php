<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Helpers\Whatsapp;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use Auth;

class DeviceController extends Controller
{
    // Device
    public function device(Request $request)
    {
        if(Auth::user()->role_id==1){
            if($request->all=='Y'){
                $device = Device::get();
            }else{
                $device = Device::where('user_id',Auth::id())->get();    
            }
            
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

    public function ExportKontak(Request $request)
    {
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Export.xls");
        $kontaks = "contacts_".$request->id.".json";
        $data = file_get_contents(url('device_info/'.$kontaks));
        // return $data;
        $data = json_decode($data,true);
        // return dd($data);
        $i = 1;
        echo "<table>
                <tr>
                    <td>No</td>
                    <td>ID</td>
                    <td>Nama</td>
                    <td>Keterangan</td>
                </tr>";
        foreach ($data['updatedContacts'] as $r) {
            $no = $r['jid'];
            $name = $r['name'] ?? $r['short'] ?? '';
            $g    = strpos($no,'@g.us') ? 'Group' : 'Kontak';
            $no   = ($g=='Group') ? $no : "'".preg_replace('/\D/','',$no);
            if($no!==''){
                echo    '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$no.'</td>
                        <td>'.$name.'</td>
                        <td>'.$g.'</td>
                    </tr>';
            }
        }
        echo "</table>";
    }

    public function getGroup(Request $request)
    {
        $kontaks = "contacts_".$request->id.".json";
        $data = file_get_contents(url('device_info/'.$kontaks));
        // dd($data);
        // exit;
        $data = json_decode($data,true);
        // return dd($data);
        $i = 1;
        echo "<table border='1' style='border-collapse: collapse;border-spacing: 10px'>
                <tr>
                    <td>No</td>
                    <td>ID</td>
                    <td>Nama</td>
                    <td>Keterangan</td>
                </tr>";
        foreach ($data['updatedContacts'] as $r) {
            $no   = $r['jid'];
            $name = $r['name'] ?? $r['short'] ?? '';
            $g    = strpos($no,'@g.us') ? 'Group' : 'Kontak';
            $no   = ($g=='Group') ? $no : "'".preg_replace('/\D/','',$no);
            if($g=='Group'){
                echo    '<tr>
                        <td>'.$i++.'</td>
                        <td>'.$no.'</td>
                        <td>'.$name.'</td>
                        <td><a href="'.url('device/export-group').'/?id='.$request->id.'&gid='.$no.'&nama='.$name.'">'.$g.'</a></td>
                    </tr>';
            }
        }
        echo "</table>";
    }

    public function ExportGroup(Request $request)
    {
        
        $device = Device::where('id',$request->id)->first();
        $ggg = [];
        if($device){
            $group = Whatsapp::getgroup(["instance"=>(String)$device->id,"gid"=>$request->gid]);
            // dd($group);
            if($group){
                $g = json_decode($group);
                echo "<table border='1' style='border-collapse: collapse;border-spacing: 10px'>
                <tr>
                    <td colspan='2'>Nama Group:</td>                                        
                    <td colspan='3'>".($request->nama ?? $g->data->subject ?? '')."</td>
                </tr>
                <tr>
                    <td>No</td>
                    <td>ID</td>
                    <td>Nama</td>
                    <td>isAdmin</td>                    
                </tr>";                
                $i=1;
                foreach ($g->data->participants as $kontak) {
                    echo    '<tr>
                                <td>'.$i++.'</td>
                                <td>'.preg_replace('/\D/','',$kontak->jid).'</td>
                                <td>'.($kontak->vname ?? '').'</td>
                                <td>'.($kontak->isAdmin ?? '').'</td>                                
                            </tr>';
                    $ggg[] = ["No"=>$i,"Phone"=>preg_replace('/\D/','',$kontak->jid),"Name"=>($kontak->vname ?? ''),"Isadmin"=>($kontak->isAdmin ?? '')];
                }

                echo '<a href="'.url('device/export-group').'/?id='.$request->id.'&gid='.$request->gid.'&nama='.$request->nama.'&dw=y">Download</a>';
                
            }
        }
        // if($request->dw){
        //     return (new FastExcel($ggg))->download('file.xlsx');
        // }
        
    }
}
