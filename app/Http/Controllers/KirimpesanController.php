<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Antrian;
use App\Models\Device;
use Auth;

class KirimpesanController extends Controller
{
    public function index(Request $request)
    {
        $row        = $request->row ?? 10;
        $kirimpesan = Antrian::where('user_id',Auth::id())->paginate($row);
        $title      = "Kirim Pesan";
        return view('kirimpesan.kirimpesan',compact('kirimpesan','title'));
    }

    public function preview(Request $request)
    {
        $preview    = Antrian::where('user_id',Auth::id())->where('status',0)->simplePaginate(6);
        $title      = "Preview Pesan";
        return view('kirimpesan.preview',compact('preview','title'));
    }

    public function process(Request $request)
    {
        $kirimpesan = Antrian::where('user_id',Auth::id())->where('status',0)->update(["status"=>1]);
        return redirect('/kirimpesan');
    }        

    public function create(Request $request)
    {
        $devices = Device::where('user_id',Auth::id())->get();
        return view('kirimpesan.pesanbaru',compact('devices'));
    }

    public function save(Request $request)
    {
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
        }else{
            $data = explode(",",$request->data_target);
            if(count($data)){
                // Proses Data
                for ($i=0; $i < count($data); $i++) {                                    
                    $phone               = preg_replace('/^0/','62',$data[$i]);
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
        return redirect('/kirimpesan/preview');
    }

    
}
