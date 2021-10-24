<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Notifikasi;
use DB;
use App\Models\Seminar;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Access;
use App\Models\Event;
use App\Models\Bank;
use App\Models\User;
use App\Models\Setting;
use App\Mail\RegistrasiMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\RegisterMailJob;
use App\Models\Notifikasi as WaNotif;
use Carbon\Carbon;

class ApiseminarController extends Controller
{


    public function index(Request $request)
    {
        $pengundang_sapaan = "";
        $pengundang_nama = "";
        $pengundang_phone = "";
        $refff = preg_replace('/^0/','62',$request->ref);
        $event = Event::where('kode_event',$request->kode_event)->first();
        $ref = User::where('kode_ref',$refff)->orWhere('phone',$refff)->first();        
        if(!$ref){
            $ref = Seminar::where('phone',$refff)->where('kode_event',$request->kode_event)->first();
        }
        if($event){
            $status = false;
            if($ref){
                $status = true;
                $pengundang_sapaan = $ref->sapaan;
                $pengundang_nama = $ref->nama;
                $pengundang_phone = $ref->phone;
            }
            return ['status'=>$status,"ref"=>$refff,'data'=>$event,'pengundang_nama'=>$pengundang_nama,'pengundang_sapaan'=>$pengundang_sapaan,'pengundang_phone'=>$pengundang_phone];
        }else{
            return ['status'=>false,'data'=>''];
        }
    }

    public function provinsi(Request $request)
    {
        return Provinsi::get();
    }

    public function kabupaten(Request $request)
    {
        if($request->id){            
            $data = Kabupaten::where('province_id',$request->id)->get();
            if($request->type=='option'){
                foreach ($data as $kab) {
                    echo '<option value="'.$kab->id.'">'.$kab->full_name.'</option>';
                }
            }else{
                return $data;
            }
        }else{
            return Kabupaten::all();
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
        \Log::info($request->all());
        $nama       = $request->nama;
        $email      = strtolower($request->email);
        $phone      = preg_replace('/^0/','62',$request->phone);
        $phone      = preg_replace('/\D/','',$phone);
        $provinsi   = $request->provinsi;
        $kab        = $request->kota;
        $kota       = DB::table('kabupatens')->where('id',$kab)->first()->full_name ?? DB::table('kabupatens')->where('id',$kab)->first()['full_name'] ??'';
        $profesi    = $request->profesi;
        $ref        = $request->ref ?? null;
        $referal = User::where('kode_ref',$ref)->orWhere('phone',$ref)->first();        
        if(!$referal){
            if($ref){
                $ref        = preg_replace('/^0/','62',$ref);
            }
            $referal = Seminar::where('phone',$ref)->where('kode_event',$request->kode_event)->first();
        }        
        \Log::info($referal);
        $panggilan  = $request->panggilan;
        $sapaan     = $request->sapaan;
        $kode_event = $request->kode_event;
        $b_tanggal  = $request->b_tanggal;
        $b_bulan    = $request->b_bulan;
        $b_tahun    = $request->b_tahun;
        $event      = Event::where('kode_event',$kode_event)->first();
        if(!$event){
            return ['status'=>false,"message"=>"Event Not Found"];
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
            return ['status'=>false,"message"=>$message];
        }else{
                $harga      = $event->harga ?? 0;
                $unix       = $this->unix($kode_event) ?? 0;                
                $total      = $harga + $unix;
                // try {
                    $ary                        = ["nama"=>$nama,"email"=>$email,"total"=>number_format($total,0),"phone"=>$phone,"provinsi"=>$provinsi,"sapaan"=>$sapaan,"tgl_seminar"=>$event->tanggal,"panggilan"=>$panggilan,"ref"=>$ref,"kota"=>$kota];
                    $message                    = ReplaceArray($ary,$event->cw_register);
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
                    $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message,"engine"=>$event->notifikasi,"delay"=>1]);
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
                                $notif           = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$ref,"message"=>$cw_referral,"engine"=>$event->notifikasi]);
                        }
                    }
                    // Email Ke Peserta
                    RegisterMailJob::dispatch($event->id,$seminar->id);
                    return ['status'=>true,"message"=>$message,"ref"=>$ref];
                // } catch (\Throwable $th) {
                //     return ['status'=>false,"message"=>'Register Failed : '.$th->getMessage()];
                // }          
                
        }
    }

    function unix($kode_event){
        $event = Event::where('kode_event',$kode_event)->first();
        if($event->harga<=0){
            return 0;
            exit;
        }
        $cek_nilai  = Seminar::where('kode_event',$kode_event)->where('status',0)->get();
        // \Log::info('data : '.$cek_nilai);        
        $in = [];
        foreach ($cek_nilai as $n) {
            $in[] = $n->unix;
        }
        $min = 1;
        $max = 999;
        for ($i=$min; $i <= $max ; $i++) { 
            $unix = rand($min,$max);
            if(!in_array($unix,$in)){        
                return $unix;
                exit;
            }
        }
    }

    public function absen(Request $request)
    {
        $emailorphone = preg_replace('/^0/','62',$request->email);
        $kode_event   = $request->kode_event;
        $seminar = Seminar::where('kode_event',$kode_event)->where('email',$emailorphone)->first();
        if(!$seminar){
            $seminar = Seminar::where('kode_event',$kode_event)->where('phone',$emailorphone)->first();
        }
        if($seminar){
            return ["status"=>true,"id"=>$seminar->id,"nama"=>$seminar->nama,"sapaan"=>$seminar->sapaan,"panggilan"=>$seminar->panggilan];
        }else{
            return ["status"=>false];
        }
    }
    
}
