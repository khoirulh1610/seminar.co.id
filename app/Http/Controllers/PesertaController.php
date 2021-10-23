<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Event;
use App\Helpers\Notifikasi;
use App\Models\User;
use Hash, DB, Auth, Str;

class PesertaController extends Controller
{
    public function index(Request $request,$kode_event)
    {
        if(Auth::user()->role_id<=2){
            $peserta    = Seminar::where("kode_event","like",$kode_event)->get();
        }else{
            $peserta    = Seminar::where("kode_event","like",$kode_event)->where('ref',Auth::user()->phone)->get();
        }
        $title      = "Data Seminar";
        return view('peserta.peserta',compact('peserta','title'));
    }

    public function rangking($kode_event)
    {
        // $q = "select * from seminars a left join (select ref,count(*) peserta from seminars where not ISNULL(ref) and kode_event='$kode_event' GROUP BY ref) b on a.phone=b.ref where a.kode_event='$kode_event' ORDER BY b.peserta desc limit 0,25";
        // $peserta    = DB::select($q);
        $title      = "Data Rangking Seminar";      
        $peserta = Seminar::where('kode_event',$kode_event)
                ->whereNotNull('ref')
                ->groupBy('ref','kode_event','tgl_seminar')
                ->selectRaw('ref,kode_event,tgl_seminar,count(*) peserta')
                ->orderBy('peserta','desc')
                ->skip(0)->take(10)
                ->get();
         return view('peserta.rangking',compact('peserta','title'));
    }

    public function approve(Request $request)
    {
            // return $request->all();
            $peserta                    = Seminar::where('status',0)->where('id',$request->id)->first();
            if($peserta){
                $peserta->total         = $request->harga;
                $peserta->status        = '1';
                $peserta->catatan       = $request->catatan;
                $peserta->type_bayar    = 'Manual';
                
                $event = Event::where('kode_event',$peserta->kode_event)->first();
                if($event){
                    $message                    = ReplaceArray($peserta,$event->cw_payment);
                    $peserta->message2          = $message;
                    $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$peserta->phone,"message"=>$message,"engine"=>$event->notifikasi,"delay"=>1]);
                    if($peserta->ref){
                        if($event->cw_payment_ref){
                            $ref                = User::where('phone',$peserta->ref)->first();
                            if(!$ref){
                                $ref                = Seminar::where('phone',$peserta->ref)->where('kode_event',$peserta->kode_event)->first();
                            }
                            if($ref){
                                $pengundang    = ["nama"=>$peserta->nama,"sapaan"=>$peserta->sapaan,"panggilan"=>$peserta->panggilan,"pengundang_nama"=>$ref->nama,"pengundang_sapaan"=>$ref->sapaan,"pengundang_panggilan"=>$ref->panggilan];
                                $cw_payment_ref = ReplaceArray($pengundang,$event->cw_payment_ref);
                                $notif          = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$peserta->ref,"message"=>$cw_payment_ref,"engine"=>$event->notifikasi,"delay"=>1]);
                            }
                            
                        }
                    }
                }
                $peserta->save();
            }
        return redirect()->back();
        
    }

    public function importkeuser(Request $request)
    {
        $peserta            = Seminar::where('id',$request->id)->first();
        if($peserta){
            $strp           = strpos($peserta->kode_event,"-");
            $brand          = substr($peserta->kode_event,0,$strp);
            $cekuser        = User::where('email',$peserta->email)->orWhere('phone',$peserta->phone)->first();
            if($cekuser){                
                return redirect()->back()->with("message","User Already Exist");
            }
            $user               = New User();
            $user->sapaan       = $peserta->sapaan;
            $user->panggilan    = $peserta->panggilan;
            $user->nama         = $peserta->nama;
            $user->phone        = $peserta->phone;
            $user->email        = $peserta->email;
            $user->role_id      = $request->role_id ?? 3;
            $user->brand        = $brand;
            $user->kode_ref     = Str::random(8);
            $user->password     = Hash::make($request->password ?? '123456');
            $user->save();
            if($user->id){
                return redirect()->back()->with("message","Register succesfuly");
            }
            return $brand;
        }
    }
    public function remove($id)
    {
        $Seminar = Seminar::find($id);
    	$Seminar->delete();
        return redirect('/peserta');
    }
}
