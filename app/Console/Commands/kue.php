<?php

namespace App\Console\Commands;

use App\Helpers\Whatsapp;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class kue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kue {id} {mulai}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         // echo getmypid()."\r\n";
         $arg = $this->arguments();
         $id  =  $arg['id'];
         $mulai  =  $arg['mulai'] ?? 0;
         $device = Device::where('id',$id)->first();
         if($device){                         
             $device->save();
             if($device->status=='AUTHENTICATED'){                
                //  $tb = "zu".$device->user_id."_antrians";
                 $tb = "zu2_antrians";
                 $antrian = DB::table($tb)->where('device_id',$device->id)->where('status',1)->skip($mulai)->orderBy('priority')->first();
                 if($antrian){
                     // echo "kirim ke ".$antrian->phone."\r\n";
                     if($antrian->phone){
                        $data = ["token"=>(String)$device->id,"phone"=>$antrian->phone,"message"=>salam($antrian->message),"file_url"=>$antrian->file];
                        $resp = Whatsapp::send($data);
                        //  print_r($resp);
                        $json = json_decode($resp);
                        $report = $json->message ?? '-';
                        $messageid= $json->data->messageid ?? '-';
                        if($report=='Terkirim'){
                            DB::table($tb)->where('id',$antrian->id)->update([
                                "report" => $report,
                                "messageid" => $messageid,
                                "status" => 2]);                         
                        }elseif ($report=='Belum Terdaftar' || $report=='File Not Found') {
                            DB::table($tb)->where('id',$antrian->id)->update([
                                "report" => $report,
                                "messageid" => '',
                                "status" => 3]);
                            
                            
                        }elseif ($report=='device offline' || $report=='Server offline') {
                            DB::table($tb)->where('id',$antrian->id)->update([
                                "report" => $report,
                                "messageid" => '',
                                "retry"=>$antrian->retry+1,
                                "status" => ($antrian->retry>1 ? 3 : 1)]);
                            echo "Device Offline\r\n";                                                  
                            $device->status = 'NOT AUTHENTICATED';                         
                            
                            $device->save();
                            // exit;
                        }else{
                            DB::table($tb)->where('id',$antrian->id)->update([
                                "report" => 'Belum Terdaftar',
                                "messageid" => 'Whatsapp Tidak Meresponse',
                                "retry"=>$antrian->retry+1,
                                "status" => ($antrian->retry>2 ? 3 : 1)]);                         
                            echo $antrian->phone."\r\n";
                            // exit;
                        }
                        echo $antrian->id.'=>'.$antrian->phone.'=>'.$antrian->pause.'=>'.$resp."\r\n";   
                        $slp = $antrian->pause * .5 > 0 ? $antrian->pause * .5 : 0;
                        sleep($slp);
                        self::handle($slp);
                     }else{
                        DB::table($tb)->where('id',$antrian->id)->update([
                            "report" => 'Belum Terdaftar',
                            "messageid" => '',
                            "retry"=>$antrian->retry+1,
                            "status" => ($antrian->retry>2 ? 3 : 1)]);                        
                        $slp = 1;
                        sleep($slp);
                        self::handle($slp);
                     }
                     
                 }else{                     
                     echo "selesai\r\n";
                     sleep(1);
                 }
             }else{                
                 echo "LOGOUT";
                 $js = Whatsapp::start(["token"=>$device->id,"mode"=>$device->mode]);
                 $json = json_decode($js);                
                 if($json->message=='AUTHENTICATED'){
                     $device->status = 'AUTHENTICATED';
                     $device->save();
                 }
                 echo $js;
             }            
         }else{
             echo $id." device not found";
         }
        
    }
}
