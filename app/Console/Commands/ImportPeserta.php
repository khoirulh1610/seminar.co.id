<?php

namespace App\Console\Commands;

use App\Models\CallbackZoom;
use App\Models\Peserta;
use App\Models\PesertaKomisi;
use App\Models\Seminar;
use DateTime;
use Illuminate\Console\Command;

class ImportPeserta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:peserta';

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
        $seminar = Seminar::orderBy('id','desc')->get();
        if($seminar){
            foreach ($seminar as $s) {
                $peserta = Peserta::where('phone',$s->phone)->orWhere('email',$s->email)->first();
                if(!$peserta){
                    $peserta = new Peserta();
                    $peserta->sapaan = $s->sapaan;
                    $peserta->panggilan = $s->panggilan;
                    $peserta->nama = $s->nama;
                    $peserta->phone = $s->phone;
                    $peserta->email = $s->email;                    
                    try {
                        new \DateTime($s->b_tahun.'-'.$s->b_bulan.'-'.$s->b_tanggal);
                        // $peserta->tgl_lahir = $s->b_tahun.'-'.$s->b_bulan.'-'.$s->b_tanggal;
                    } catch (\Exception $e) {
                        // return false;
                    }
                    $peserta->ref = $s->ref;
                    $peserta->profesi = $s->profesi;
                    $peserta->provinsi = $s->provinsi;
                    $peserta->kota  = $s->kota;
                    $peserta->password = rand(100000,999999);
                    $peserta->save();
                }
            }
        }

        $komisis = Seminar::where('kode_event','5WXf1')->get();
        foreach ($komisis as $s) {            
            $pengundang = Seminar::where('phone',$s->ref)->orderBy('id','desc')->first();            
            if($pengundang){                
                if($s->phone){                    
                    $komisi = PesertaKomisi::where('phone',$s->phone)->first();
                    if(!$komisi){                        
                        $komisi         = new PesertaKomisi();
                        $komisi->komisi = 2000;
                        $komisi->status = 0;
                        $komisi->phone  = $s->phone;
                        $komisi->ref    = $s->ref;
                        $komisi->keterangan = 'Komisi Undangan '.$s->nama.' '.($s->event->event_title ?? $s->kode_event);
                        $komisi->save();
                    }
                }                
            }
        }

        // $callback   = CallbackZoom::get();
        // foreach ($callback as $r) {
        //     $js = json_decode($r->data);
        //     $email = $js->payload->object->participant->email ?? null;
        //     $absen_at = date('Y-m-d H:i:s',$js->event_ts) ?? null;
        //     $seminar  = Seminar::where('email',$email)->orderBy('id','desc')->first();
        //     if($seminar){
        //         $komisi = PesertaKomisi::where('phone',$seminar->phone)->where('status',0)->first();
        //         if($komisi){
        //             $komisi->status = 1;
        //             $komisi->absen_at = Date('Y-m-d H:i') ; //$absen_at;
        //             $komisi->save();
        //         }
        //     }
        // }

    }
}
