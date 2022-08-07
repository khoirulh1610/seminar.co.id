<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Helpers\Whatsapp;
use App\Models\User;
use App\Models\Server;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;

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
        $server = Server::get();
        $title = "List Device";
        return view('whatsapp.device',compact('device','title','user','server'));
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
            return Whatsapp::start(["token"=>$device->id,'mode'=>$device->mode]);
        }        
    }

    public function send(Request $request)
    {        
        $device = Device::where('id',$request->id)->first();
        $send   = Whatsapp::send(["token"=>$device->id,
            'phone'=>'6285232843165',
            'message'=>'Tes Kirim Pesan jam '.date('H:i')
        ]);       
        return redirect()->back()->with('message','Pesan Terkirim');
    }

    public function baru(Request $request)
    {
        $device             = new Device;        
        $device->user_id    = $request->user;        
        $device->label      = Str::random(10);
        $device->server_id  = $request->server_id;
        $device->save();        
        return redirect('/device/device');
    }

    public function qrcode(Request $request, $id)
    {
        try {
            $device             = Device::where('id', $id)->first();
            $resp               = Whatsapp::qrcode(["token"=>(String)$device->id], true);
            $r                  = json_decode($resp); 
            if($r->message=='token tidak tersedia'){
                return Whatsapp::start(["token"=>(String)$device->id,'mode'=>$device->mode]);
            }
            // return $resp;
            if ($device) {               
                $data = $r->data ?? null;
                if($data){                    
                    $device->status     = 'AUTHENTICATED';
                    $phone              = explode(':',$r->data->id)[0] ?? '';
                    $device->phone      = explode('@',$phone)[0] ?? '';
                    $device->name       = $r->data->name ?? '';
                    $device->pic_url    = $r->pic;
                    $device->save();
                }
                return $resp;
            } else {
                return ["message" => "Device Not Found"];
            }
        } catch (\Throwable $th) {
            return abort(500, $th->getMessage());
        }
    }
    
    public function delete(Request $request)
    {
        $device = Device::where('id',$request->id)->first();
        if($device){
            $logout = Whatsapp::logout(["token"=>(String)$device->id]);
            $device = Device::where('id',$request->id)->delete();
        }
        return redirect('/device/device');
    }

    public function ExportKontak(Request $request)
    {
        $data = [];
        $contact = DB::connection('mongodb')->collection("contacts_".$request->id)->get();    
        foreach ($contact as $r) {
            $no = $r['jid'];
            $name = $r['name'] ?? $r['short'] ?? '';
            $g    = strpos($no,'@g.us') ? 'Group' : 'Kontak';
            $no   = ($g=='Group') ? $no : preg_replace('/\D/','',$no);
            if($no!==''){
                $data[] = ["Phone"=>$no,"Nama"=>$name,"Ket"=>$g];
            }
        }
        $file = "files/kotak_".$request->id.'_'.time().".xlsx";
        $f = (new FastExcel($data))->export($file);
        return redirect($file);
    }

    public function getGroup(Request $request)
    {
        $group  = Whatsapp::group(['token' => $request->id]);
        $group  = json_decode($group);
        $group  = $group->data ?? [];
        $iteration = 1;
        $collection = collect([]);
        foreach ($group as $id_group => $data) {
            $collection->push([
                'No'            => $iteration++,
                'Id'            => $data->id,
                'Nama Group'    => $data->subject,
                'Jumlah Member' => count($data->participants),
            ]);
        }
        return (new FastExcel($collection))->download('data_group.xlsx');
    }

    public function updateMode(Request $request)
    {
        $device = Device::where('id',$request->id)->first();
        if($device->mode == 'std'){
            $device = Device::where('id',$request->id)->where('mode', 'std')->update([ 'mode' => 'md' ]);
        }elseif($device->mode == 'md'){
            $device = Device::where('id',$request->id)->where('mode', 'md')->update([ 'mode' => 'std' ]);
        }
        // return 1;
        $notif = Whatsapp::restart(["token" => (string)$request->id]);
        return redirect('device/show?id='.$request->id);
    }

    public function ExportGroup(Request $request)
    {
        
        $device = Device::where('id',$request->id)->first();
        $file   = time().".xlsx";
        $ggg = [];
        if($device){
            $group = Whatsapp::group(["token"=>(String)$device->id,"gid"=>$request->gid]);
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
                    $ggg[] = ["No"=>$i,"Phone"=>preg_replace('/\D/','',$kontak->jid),"Name"=>($kontak->vname ?? ''),"Isadmin"=>($kontak->isAdmin ? 'Y' : 'N'),"Group"=>($request->nama ?? $g->data->subject ?? '')];
                }

                echo '<a href="'.url($file).'">Download</a>';
                
                
            }
        }
        (new FastExcel($ggg))->export($file);
    }

    public function getAllGroup(Request $request)
    {
        $contact = DB::connection('mongodb')->collection("contacts_".$request->id)->where('jid','like','%@g.us')->groupBy('jid','name')->get(); 
        $i =1;
        $data = [];
        foreach ($contact as $g) {
            // echo $g['jid']."<br>";
            $group =  DB::connection('mongodb')->collection("g_".$request->id)->where('id',$g['jid'])->get();             
            foreach ($group as $gd) {                
                foreach ($gd['participants'] as $k) {
                    $nama_group = $g['name'] ?? '';
                    $phone      = preg_replace('/\D/','',$k['jid']);
                    $nama       = $k['name'] ?? $k['shot'] ?? $k['notify'] ?? $k['vname'] ?? '';
                    $isAdmin    = $k['isAdmin'] ? 'Y' : 'N';
                    $data[]     = ["No"=>$i++,"phone"=>$phone,"nama"=>$nama,"isAdmin"=>$isAdmin,"group"=>$nama_group];
                }
            }
        }  
        $file = "files/gdevice_".$request->id.".xlsx";
        $f = (new FastExcel($data))->export($file);
        return redirect($file);
    }


}
