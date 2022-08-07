<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PesertaInject;
use App\Helpers\HelperZoom;
use App\Models\Seminar;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Models\Zoom;

class Regzoom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regzoom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Ulang ZOOM';

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
        $event = Event::where('kode_event','LifeForWin')->first();
        if($event){
            $myzoom = Zoom::where('id',$event->zoom_id)->first();
            if($myzoom){
                $zoom = new \MacsiDigital\Zoom\Support\Entry($myzoom->key, $myzoom->secret, 60 * 60 * 24 * 7, 5, 'https://api.zoom.us/v2/');
                $user = new \MacsiDigital\Zoom\User($zoom);
                $meeting = new \MacsiDigital\Zoom\Meeting($zoom);                    
                if($event->meeting_id){
                    $seminars = Seminar::where('kode_event',$event->kode_event)->whereNull('join_zoom')->get();
                    foreach ($seminars as $p) {
                        try {                    
                            $registrant = $meeting->find($event->meeting_id)->registrants()->create(['first_name' => $p->sapaan, 'last_name' => $p->panggilan.', '.$p->kota, 'email' => $p->email]);
                            Seminar::where('id',$p->id)->update(['join_zoom'=>$registrant->join_url]);
                            echo $p->email.'=>'.$registrant->join_url."\r\n";
                        } catch (\Throwable $th) {
                            Seminar::where('id',$p->id)->update(["join_zoom"=>'-']);      
                        }
                    }
                }
                
                
            }
        }
        
        
        

        // $event = Event::where('kode_event','pIXYB')->first();
        // if($event){
        //     $peserta = Seminar::whereNull('join_zoom')->where('kode_event',$event->kode_event)->get();
        //     foreach ($peserta as $p) {
        //         try {
        //             $sapaan = $p->sapaan;
        //             $nama   = $p->nama;
        //             $email  = $p->email;            
        //             $link   = HelperZoom::join($sapaan,$nama,$email,$event->meeting_id);
        //             echo $sapaan.$nama.$email."=>".$link."\r\n";
        //             Seminar::where('id',$p->id)->update(["join_zoom"=>$link]);
        //             // sleep(rand(1,3));
        //         } catch (\Throwable $th) {
        //             Seminar::where('id',$p->id)->update(["join_zoom"=>'-']);
        //         }
        //     }
        // }
        
    }
}
