<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Antrian;
use App\Models\Device;
use App\Helpers\Whatsapp;
use Illuminate\Support\Facades\Auth;

class KirimpesanController extends Controller
{
    public function index(Request $request)
    {
        $row        = $request->row ?? 10;
        $kirimpesan = Antrian::where('user_id',Auth::id())->orderBy('id','desc')->paginate($row);
        $status_pesan = Antrian::where('user_id',Auth::id())->groupBy('report')->pluck('report');
        $title      = "Kirim Pesan";
        return view('kirimpesan.kirimpesan',compact('kirimpesan','title','status_pesan'));
    }

    public function preview(Request $request)
    {
        $preview    = Antrian::where('user_id',Auth::id())->where('status','<=',1)->simplePaginate(6);
        $title      = "Preview Pesan";
        return view('kirimpesan.preview',compact('preview','title'));
    }

    public function process(Request $request)
    {
        // Antrian::where('user_id',Auth::id())->where('phone',"")->update(["status"=>3,"report"=>"No Tidak Valid"]);
        // Antrian::where('user_id',Auth::id())->where('phone',null)->update(["status"=>3,"report"=>"No Tidak Valid"]);
        // $kirimpesan = Antrian::where('user_id',Auth::id())->where('status',0)->update(["status"=>1]);

        $update                     = Antrian::where('user_id', Auth::user()->id)->where('status',0)->update(["status"=>1]);
        $data                       = Antrian::selectRaw('device_id')->where('user_id', Auth::id())->where('status',1)->groupBy('device_id')->get();
        $pesan = [];
        foreach ($data as $row) {            
            $all                    = Antrian::selectRaw('message, phone, id, pause,file file_url')->where('user_id', Auth::id())->where('status', 1)->where('device_id', $row->device_id)->get();
            $p =[];
            foreach ($all as $rr) {
                $p[] =[
                    "id"=>$rr->id,
                    "phone"=>$rr->phone,
                    "message"=>$rr->message,
                    "file_url"=>$rr->file_url,
                    "pause"=>$rr->pause
                ];
            }
            $pesan = [
                'token' => $row->device_id,
                "renew" => true,
                'data' => $p
            ];
            
           $kirim = Whatsapp::queue($pesan);
        //    return $kirim;
        }

        return redirect('/kirimpesan');
    }        

    public function create(Request $request)
    {
        $devices = Device::where('user_id',Auth::id())->get();
        return view('kirimpesan.pesanbaru',compact('devices'));
    }

    public function save(Request $request)
    {
        try {
            $lampiran      = null ;
            $path_lampiran = null ;
            $file_name     = null ;
            if($request->lampiran){
                $file = $request->file('lampiran');
                $filepath = 'uploads/';
                $fileName = 'lampiran_'.time().".".$file->getClientOriginalExtension();
                $file_name = $file->getClientOriginalName();
                $file->move('uploads/',$fileName);
                $lampiran = url('uploads/'.$fileName);       
                $path_lampiran =  'uploads/'.$fileName;     
            }

            if($request->target=="Upload"){
                $file = $request->file('file');
                $filepath = 'uploads/';
                $fileName = 'file_'.time().".".$file->getClientOriginalExtension();
                $file->move('uploads/',$fileName);
                $data = (new FastExcel)->import($filepath.$fileName);
                if(file_exists($filepath.$fileName)){
                    unlink($filepath.$fileName);
                }
                // Proses Data
                foreach ($data as $exl) {                
                    if($exl['phone']){
                        $message               = ReplaceArray($exl,$request->message);                                    
                        $phone                 = preg_replace('/^0/','62',$exl['phone']);
                        $phone                 = preg_replace('/\D/','',$phone);
                        if($phone){
                            $antrian               = new Antrian();
                            $antrian->user_id      = Auth::id();
                            $antrian->device_id    = $request->device_id;
                            $antrian->phone        = $phone;
                            $antrian->message      = $message;
                            $antrian->status       = 0;
                            $antrian->pause        = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file         = $lampiran;
                            $antrian->file_name    = $file_name;
                            $antrian->file_path    = $path_lampiran;
                            $antrian->type_message = $request->addf;
                            $antrian->save();                    
                        }
                    }
                }
            }else{
                $data = explode(",",$request->data_target);
                if(count($data)){
                    // Proses Data
                    for ($i=0; $i < count($data); $i++) {                                    
                        $phone               = preg_replace('/^0/','62',$data[$i]);
                        if($phone){
                            $antrian             = new Antrian();
                            $antrian->user_id    = Auth::id();
                            $antrian->device_id  = $request->device_id;
                            $antrian->phone      = $phone;
                            $antrian->message    = $request->message;
                            $antrian->status     = 0;
                            $antrian->pause      = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file       = $lampiran;
                            $antrian->file_name  = $file_name;
                            $antrian->file_path  = $path_lampiran;
                            $antrian->type_message = $request->addf;
                            $antrian->save();                    
                        }
                    }
                }
            }
            return redirect('/kirimpesan/preview');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function send(Request $request)
    {
        $antrian = Antrian::where('user_id',Auth::id())->where('id',$request->id)->first();
        
        if($antrian){
            $data = ["token"=>$antrian->device_id,"phone"=>$antrian->phone,"message"=>$antrian->message,"file_url"=>$antrian->file,"file_name"=>$antrian->file_name];            
            $notif = Whatsapp::send($data);            
            $r = json_decode($notif);
            if($r){
                if($r->message=='Terkirim'){
                    $antrian->status = 2;
                    $antrian->messageid = $r->data->messageid ?? '';
                    $antrian->report = $r->data->message ?? '';
                    $antrian->save();
                }else{
                    $antrian->status = 2;
                    $antrian->report = $r->data->message ?? '';
                    $antrian->save();
                }
            }
            return $notif;
        }else{
            return ["status"=>false,"message"=>"Data not found"];
        }
    }
    
    public function remove(Request $request)
    {
        
        if($request->status=="semua"){
            $antrian = Antrian::where("user_id",Auth::id());
        }else{            
            $antrian = Antrian::where("user_id",Auth::id())->where('status',$request->status);
            if($request->id){
                $antrian = Antrian::where("user_id",Auth::id())->where('id',$request->id);
            }
        }
        if($antrian){
            $antrian->delete();
        }
        return redirect('/kirimpesan');
    }

    public function batal(Request $request)
    {
        $remove     = Antrian::where('user_id', Auth::id())->where('status', 0)->delete();
        return redirect('/kirimpesan');
    }

}
