<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Antrian;
use App\Models\Device;
use App\Helpers\Whatsapp;
use App\Models\Event;
use App\Models\Peserta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimpesanController extends Controller
{
    public function index(Request $request)
    {
        $row            = $request->row ?? 10;
        $kirimpesan     = Antrian::where('user_id',Auth::id())->orderBy('id','desc')->where('type_message', 'Text')->paginate($row);
        $status_pesan   = Antrian::where('user_id',Auth::id())->where('type_message', 'Text')->groupBy('report')->pluck('report');
        $title          = "Kirim Pesan";
        return view('kirimpesan.kirimpesan',compact('kirimpesan','title','status_pesan'));
    }

    public function preview(Request $request)
    {
        $preview    = Antrian::where('user_id',Auth::id())->where('status','<=',1)->where('type_message', 'Text')->simplePaginate(6);
        $title      = "Preview Pesan";
        return view('kirimpesan.preview',compact('preview','title'));
    }

    public function process(Request $request)
    {
        // Antrian::where('user_id',Auth::id())->where('phone',"")->update(["status"=>3,"report"=>"No Tidak Valid"]);
        // Antrian::where('user_id',Auth::id())->where('phone',null)->update(["status"=>3,"report"=>"No Tidak Valid"]);
        // $kirimpesan = Antrian::where('user_id',Auth::id())->where('status',0)->update(["status"=>1]);

        $update                     = Antrian::where('user_id', Auth::user()->id)->where('status',0)->update(["status"=>1]);
        $data                       = Antrian::selectRaw('device_id')->where('user_id', Auth::id())->where('status',1)->groupBy('device_id')->take(3000)->get();
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
        $devices        = Device::where('user_id',Auth::id())->get();
        if(Auth::user()->role_id == 1){
            $devices        = Device::all();
        }

        $log            = DB::table('logkirims')->where('user_id', Auth::user()->id)->where('jenis_proses', 'Text')->orderBy('id', 'desc')->first();
        $event          = Event::orderBy('tgl_event', 'DESC')->get();
        return view('kirimpesan.pesanbaru',compact('devices', 'log', 'event'));
    }

    public function save(Request $request)
    {
        try {
            $type            = 'Text';
            $lampiran1       = null ;
            $lampiran2       = null ;
            $path_lampiran1  = null ;
            $path_lampiran2  = null ;
            $file_name1      = null ;
            $file_name2      = null ;
            if($request->lampiran1){
                $file           = $request->file('lampiran1');
                $filepath       = 'uploads/';
                $fileName1      = 'lampiran1_'.time().".".$file->getClientOriginalExtension();
                $file_name2      = $file->getClientOriginalName();
                $file->move('uploads/',$fileName1);
                $lampiran1      = url('uploads/'.$fileName1);       
                $path_lampiran2  = 'uploads/'.$fileName1;     
            }

            if($request->lampiran2){
                $file           = $request->file('lampiran2');
                $filepath       = 'uploads/';
                $fileName2      = 'lampiran2_'.time().".".$file->getClientOriginalExtension();
                $file_name2      = $file->getClientOriginalName();
                $file->move('uploads/',$fileName2);
                $lampiran2      = url('uploads/'.$fileName2);       
                $path_lampiran2  = 'uploads/'.$fileName2;     
            }

            // Log History Pesan
            $l      = DB::table('logkirims')->insert([
                "jenis_proses"  => "Text",
                "user_id"       => Auth::user()->id,
                "message1"      => $request->message1,
                "message2"      => $request->message2,
                "device_id"     => $request->device_id,
                "target"        => $request->target,
                "file1"         => $lampiran1,
                "file2"         => $lampiran2,
                "created_at"    => Carbon::now()
            ]);

            if($request->target=="Upload"){
                $file           = $request->file('file');
                $filepath       = 'uploads/';
                $fileName       = 'file_'.time().".".$file->getClientOriginalExtension();
                $file->move('uploads/',$fileName);
                $data           = (new FastExcel)->import($filepath.$fileName);
                if(file_exists($filepath.$fileName)){
                    unlink($filepath.$fileName);
                }

                // Proses Data
                foreach ($data as $exl) {                
                    if($exl['phone']){
                        $message1               = ReplaceArray($exl,$request->message1);                                  
                        $message2               = ReplaceArray($exl,$request->message2);                                  
                        $phone                 = preg_replace('/^0/','62',$exl['phone']);
                        $phone                 = preg_replace('/\D/','',$phone);
                        if($phone){
                            $antrian               = new Antrian();
                            $antrian->user_id      = Auth::id();
                            $antrian->device_id    = $request->device_id;
                            $antrian->phone        = $phone;
                            $antrian->message      = $message1;
                            $antrian->status       = 0;
                            $antrian->pause        = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file         = $lampiran1;
                            $antrian->file_name    = $file_name1;
                            $antrian->file_path    = $path_lampiran1;
                            $antrian->type_message = $type;
                            $antrian->save();                    
                        }

                        if($request->message2){
                            if($phone){
                                $antrian               = new Antrian();
                                $antrian->user_id      = Auth::id();
                                $antrian->device_id    = $request->device_id;
                                $antrian->phone        = $phone;
                                $antrian->message      = $message2;
                                $antrian->status       = 0;
                                $antrian->pause        = rand($request->min ?? 0,$request->max ?? 10);
                                $antrian->file         = $lampiran2;
                                $antrian->file_name    = $file_name2;
                                $antrian->file_path    = $path_lampiran2;
                                $antrian->type_message = $type;
                                $antrian->save();                    
                            }
                        }
                    }
                }
            }else if($request->target == "Manual"){
                $data = explode(",",$request->data_target);
                // dd($data);
                if(count($data)){
                    // Proses Data
                    for ($i=0; $i < count($data); $i++) {                                    
                        $phone               = preg_replace('/^0/','62',$data[$i]);
                        if($phone){
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = $request->message1;
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file          = $lampiran1;
                            $antrian->file_name     = $file_name1;
                            $antrian->file_path     = $path_lampiran1;
                            $antrian->type_message  = $type;
                            $antrian->save();                    
                        }

                        if($request->message2){
                            if($phone){
                                $antrian                = new Antrian();
                                $antrian->user_id       = Auth::id();
                                $antrian->device_id     = $request->device_id;
                                $antrian->phone         = $phone;
                                $antrian->message       = $request->message2;
                                $antrian->status        = 0;
                                $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                                $antrian->file          = $lampiran2;
                                $antrian->file_name     = $file_name2;
                                $antrian->file_path     = $path_lampiran2;
                                $antrian->type_message  = $type;
                                $antrian->save();                    
                            }
                        }
                    }
                }
            }else if($request->target == "Seminar"){
                if($request->target_kirim == "Semua Peserta"){
                    $peserta    = DB::select("select * from seminars where kode_event like '%".$request->kode_event."%'");
                    foreach($peserta as $participt){
                        $phone               = preg_replace('/^0/','62',$participt->phone);
                        if($phone){
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = ReplaceArray((Array)$participt, $request->message1);
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file          = $lampiran1;
                            $antrian->file_name     = $file_name1;
                            $antrian->file_path     = $path_lampiran1;
                            $antrian->type_message  = $type;
                            $antrian->save();                    
                        }

                        if ($request->message2) {
                            if($phone){
                                $antrian                = new Antrian();
                                $antrian->user_id       = Auth::id();
                                $antrian->device_id     = $request->device_id;
                                $antrian->phone         = $phone;
                                $antrian->message       = ReplaceArray((Array)$participt, $request->message2);
                                $antrian->status        = 0;
                                $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                                $antrian->file          = $lampiran2;
                                $antrian->file_name     = $file_name2;
                                $antrian->file_path     = $path_lampiran2;
                                $antrian->type_message  = $type;
                                $antrian->save();                    
                            }
                        }
                    }
                }else if($request->target_kirim == "Sudah Absen"){
                    $peserta    = DB::select("select * from seminars where id in (select seminar_id from absensis where kode_event like '%".$request->kode_event."%')");

                    foreach($peserta as $participt){
                        $phone               = preg_replace('/^0/','62',$participt->phone);
                        if($participt->phone){
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $participt->phone;
                            $antrian->message       = ReplaceArray((Array)$participt, $request->message1);
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file          = $lampiran1;
                            $antrian->file_name     = $file_name1;
                            $antrian->file_path     = $path_lampiran1;
                            $antrian->type_message  = $type;
                            $antrian->save();                    
                        }

                        if ($request->message2) {
                            if($participt->phone){
                                $antrian                = new Antrian();
                                $antrian->user_id       = Auth::id();
                                $antrian->device_id     = $request->device_id;
                                $antrian->phone         = $participt->phone;
                                $antrian->message       = ReplaceArray((Array)$participt, $request->message2);
                                $antrian->status        = 0;
                                $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                                $antrian->file          = $lampiran2;
                                $antrian->file_name     = $file_name2;
                                $antrian->file_path     = $path_lampiran2;
                                $antrian->type_message  = $type;
                                $antrian->save();                    
                            }
                        }
                    }
                }else if($request->target_kirim == "Belum Absen"){
                    $peserta    = DB::select("select * from seminars where id Not In (select seminar_id from absensis where kode_event like '".$request->kode_event."') and kode_event like '%".$request->kode_event."%'");
                    foreach($peserta as $participt){
                        $phone               = preg_replace('/^0/','62',$participt->phone);
                        if($phone){
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = ReplaceArray((Array)$participt, $request->message1);
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                            $antrian->file          = $lampiran1;
                            $antrian->file_name     = $file_name1;
                            $antrian->file_path     = $path_lampiran1;
                            $antrian->type_message  = $type;
                            $antrian->save();                    
                        }

                        if ($request->message2) {
                            if($phone){
                                $antrian                = new Antrian();
                                $antrian->user_id       = Auth::id();
                                $antrian->device_id     = $request->device_id;
                                $antrian->phone         = $phone;
                                $antrian->message       = ReplaceArray((Array)$participt, $request->message2);
                                $antrian->status        = 0;
                                $antrian->pause         = rand($request->min ?? 0,$request->max ?? 10);
                                $antrian->file          = $lampiran2;
                                $antrian->file_name     = $file_name2;
                                $antrian->file_path     = $path_lampiran2;
                                $antrian->type_message  = $type;
                                $antrian->save();                    
                            }
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
            $antrian = Antrian::where("user_id",Auth::id())->where('type_message','Text');
        }else{            
            $antrian = Antrian::where("user_id",Auth::id())->where('status',$request->status)->where('type_message','Text');
            if($request->id){
                $antrian = Antrian::where("user_id",Auth::id())->where('id',$request->id)->where('type_message','Text');
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

    public function pause(Request $request)
    {
        $antrian = Antrian::where('user_id',Auth::id())->where('status', 1)->get();
        if($antrian){
            foreach($antrian as $a){
                $a->status = 0;
                $a->save();
            }
        }
        return redirect('/kirimpesan');
    }

    public function lanjut(Request $request)
    {
        $antrian = Antrian::where('user_id',Auth::id())->where('status', 0)->get();
        if($antrian){
            foreach($antrian as $a){
                $a->status = 1;
                $a->save();
            }
        }
        return redirect('/kirimpesan');
    }

}
