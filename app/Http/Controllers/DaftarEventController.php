<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminar;
use App\Models\Notifikasi as WaNotif;
use App\Helpers\Notifikasi;
use App\Helpers\Whatsapp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Access;

class DaftarEventController extends Controller
{
    public function index(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.',$domain)[0])->first();
        if(!$event){
            return abort(404,'Halaman tidak ditemukan');
        }
        $ref = $request->ref;
        $pengndang = User::where('phone',$ref)->orWhere('kode_ref',$ref)->first();
        if(!$pengndang){
            $ref = preg_replace('/^0/','62',$ref);
            $pengndang = Seminar::where('phone',$ref)->first();
        }
        $pengundang_nama = $pengndang->nama ?? '';
        $buka_pendaftaran = 1;        
        return view('DaftarEvent.index',compact('pengundang_nama','buka_pendaftaran','event'));
    }
    

    public function kabupaten()
    {
        $kab = file_get_contents("./data/kabupaten.json");
        if(isset($_GET['id'])){
            $data = json_decode($kab);
            $province_id = $_GET['id'] ?? '';
            foreach ($data as $k) {
                if($k->province_id==$province_id){
                    echo '<option value="'.$k->id.'">'.$k->full_name.'</option>';
                }
            }
        }else{
            $data = json_decode($kab);    
            foreach ($data as $k) {        
                echo '<option value="'.$k->id.'">'.$k->full_name.'</option>';        
            }
        }
        
    }

    public function register(Request $request)
    {

        $Access = new Access();
        $Access->nama = $request->nama;
        $Access->phone = $request->phone;
        $Access->email = $request->email;
        $Access->user_agent = $request->header('User-Agent');
        $Access->ip = $request->ip();
        $Access->save();
        
        Log::info($request->all());

        $nama       = $request->nama;
        $email      = strtolower($request->email);
        $phone      = preg_replace('/^0/','62',$request->phone);
        $phone      = preg_replace('/\D/','',$phone);
        $provinsi   = $request->provinsi;
        $kab        = $request->kota;
        $kota       = DB::table('kabupatens')->where('id',$kab)->first()->full_name ?? DB::table('kabupatens')->where('id',$kab)->first()['full_name'] ??'';
        $profesi    = $request->profesi;
        $ref        = $request->ref ?? null;
        $referal    = User::where('kode_ref',$ref)->orWhere('phone',$ref)->first();        
        if(!$referal){
            if($ref){
                $ref        = preg_replace('/^0/','62',$ref);
            }
            $referal = Seminar::where('phone',$ref)->where('kode_event',$request->kode_event)->first();
        }        
        Log::info($referal);
        $panggilan  = $request->panggilan;
        $sapaan     = $request->sapaan;
        $kode_event = $request->kode_event;
        $b_tanggal  = $request->tanggal;
        $b_bulan    = $request->bulan;
        $b_tahun    = $request->tahun;
        $event      = Event::where('kode_event',$kode_event)->first();
        if(!$event){
            // return ['status'=>false,"message"=>"Event Not Found"];
            return redirect()->back()->with(['message'=>'Event Not Found','status'=>1]);
        }        
        $cek        = Seminar::where('email',$email)->where('kode_event',$kode_event)->where('tgl_seminar',$event->tgl_event)->first();
        if(!$cek){
            $cek        = Seminar::where('phone',$phone)->where('kode_event',$kode_event)->where('tgl_seminar',$event->tgl_event)->first();            
        }
        if($cek){
            if($cek->status==1){
                // Notif sudah daftar & bayar
                $message    =  "Email Sudah Terdaftar & Pembayaran Lunas" ;
                // $notif      = Wa::Notif($phone,$message);
            }else if($cek->status==0){
                // Notif sudah daftar belum bayar
                $message    = "Email Sudah Terdaftar & Pembayaran Belum Lunas";
                // $notif      = Wa::Notif($phone,$message);
            }
            // return redirect()->back()->with('error','Data Hp :'.$phone.' Email : '.$email.' Sudah terdaftar, Gunakan email yg lain');
            if($event->type=='gratis'){
                $message    = "Email / Phone Sudah Terdaftar" .$cek->phone." ".$cek->email." ".$cek->kode_event;
            }
            return redirect()->back()->with(['message'=>$message,'status'=>1]);
        }else{
                $harga      = $event->harga ?? 0;
                $unix       = rand(1,999) ?? 0;                
                $total      = ($harga > 0 ? $harga + $unix : 0);
                // try {
                    $ary                        = ["nama"=>$nama,"email"=>$email,"total"=>number_format($total,0),"phone"=>$phone,"provinsi"=>$provinsi,"sapaan"=>$sapaan,"tgl_seminar"=>$event->tanggal,"panggilan"=>$panggilan,"profesi"=>$profesi,"ref"=>$ref,"kota"=>$kota];
                    $message                    = ReplaceArray($ary,$event->cw_register);
                    $message2                   = false; 
                    if($event->cw_register2){
                        $message2                    = ReplaceArray($ary,$event->cw_register2);
                    }
                    $seminar                    = new Seminar();
                    $seminar->sapaan            = $sapaan;
                    $seminar->panggilan         = $panggilan;
                    $seminar->nama              = $nama;
                    $seminar->email             = $email;
                    $seminar->phone             = $phone;     
                    $seminar->profesi           = $profesi;               
                    $seminar->prov_id           = $provinsi;
                    $seminar->provinsi          = DB::table('provinsis')->where('id',$provinsi)->first()->name ?? DB::table('provinsis')->where('id',$provinsi)->first()['name'] ??'';
                    $seminar->kota_id           = $kab;
                    $seminar->kota              = $kota;
                    $seminar->harga             = $harga;
                    $seminar->unix              = $unix;
                    $seminar->total             = $total;
                    $seminar->status            = 0;
                    $seminar->message           = $message;      
                    $seminar->ref               = $referal->phone ?? $ref ?? null;  
                    $seminar->tgl_seminar       = $event->tgl_event;       
                    $seminar->kode_event        = $kode_event;  
                    $seminar->fee_referral      = $event->fee_referral ?? 0;
                    $seminar->fee_admin         = $event->fee_admin ?? 0;
                    $seminar->b_tanggal         = $request->b_tanggal;
                    $seminar->b_bulan           = $request->b_bulan;
                    $seminar->b_tahun           = $request->b_tahun;     
                    $seminar->save();           
                    // Notifikasi ke peserta                 
                    $WaNotif = new WaNotif();
                    $WaNotif->kode_event = $kode_event;
                    $WaNotif->phone = $phone;
                    $WaNotif->notif = $message;
                    $WaNotif->judul = "Notifikasi user daftar";
                    $WaNotif->nama  = $nama;
                    $WaNotif->save();

                    // $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message,"engine"=>$event->notifikasi,"delay"=>0]);                    
                    // if($message2){
                    //     $notif2                 = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message2,"engine"=>$event->notifikasi,"delay"=>0]);
                    // }
                    // $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>'120363023657414562@g.us',"message"=>$message,"engine"=>$event->notifikasi,"delay"=>1]);

                    $notif1 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>$phone,"message"=>$message]);
                    if($message2){
                        $notif2 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>$phone,"message"=>$message2]);
                    }
                    // $notif3 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>'6281228060666-1635994060@g.us',"message"=>$message]);

                    // web Notif
                    $data = [   
                        "title"=>"Pendaftar Seminar ".$kode_event ,
                        "body"=>"Nama : ".$nama." Email : ".$email
                    ];
                    $webnotif = Notifikasi::fcmAll($data); 
                    // Notifikasi Ke Pengundang
                    if($referal){
                        if($event->cw_referral){
                            $jumlah_undangan = Seminar::where('ref',$referal->phone)->where('kode_event',$kode_event)->count();
                            $ary2            = [    
                                                "nama"=>$nama,
                                                "email"=>$email,
                                                "total"=>number_format($total,0),
                                                "phone"=>$phone,
                                                "provinsi"=>$provinsi,
                                                "sapaan"=>$sapaan,
                                                "profesi"=>$profesi,
                                                "tgl_seminar"=>$event->tanggal,
                                                "panggilan"=>$panggilan,
                                                "ref"=>$ref,
                                                "kota"=>$kota,
                                                "jumlah_undangan"=>$jumlah_undangan,
                                                "pengundang_sapaan"=> $referal->sapaan ?? null,
                                                "pengundang_nama" => $referal->nama ?? null,                                                         
                                                "pengundang_panggilan" => $referal->panggilan ?? null,                                                         
                                            ];
                                $cw_referral  = ReplaceArray($ary2,$event->cw_referral);
                                $WaNotif = new WaNotif();
                                $WaNotif->phone = $ref;
                                $WaNotif->notif = $cw_referral;
                                $WaNotif->kode_event = $kode_event;
                                $WaNotif->judul = "Notifikasi user daftar ke pengundang";
                                $WaNotif->nama  = $referal->nama ?? null;
                                $WaNotif->save();
                                // $notif           = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$ref,"message"=>$cw_referral,"engine"=>$event->notifikasi]);
                                // $notif_g         = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>'6281228060666-1635994060@g.us',"message"=>$cw_referral,"engine"=>$event->notifikasi]);
                                $notif4 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>$ref,"message"=>$cw_referral]);
                                $notif5 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>'6281228060666-1635994060@g.us',"message"=>'*Info Group :* '.$cw_referral]);
                        }
                    }
                    
                    
                    // return ['status'=>true,"message"=>$message,"ref"=>$ref];
                    return redirect()->back()->with(['message'=>$message,'status'=>1]);
                // } catch (\Throwable $th) {
                //     return ['status'=>false,"message"=>'Register Failed : '.$th->getMessage()];
                // }          
                
        }
    }
}
