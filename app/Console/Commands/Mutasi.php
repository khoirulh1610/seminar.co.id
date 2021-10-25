<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use BCAParser\BCAParser;
use App\Models\Transaksi;
use App\Models\Mutasi as Mts;
use App\Models\Seminar;
use App\Models\Setting;
use App\Models\Bank;
use App\Models\User;
use App\Helpers\Wa;
use App\Models\Event;
use App\Helpers\Notifikasi;

class Mutasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mutasi';

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
        $bnk = Bank::all();
        foreach ($bnk as $bank) {
            $Parser = new BCAParser($bank->username,$bank->password);
            $saldo = $Parser->getSaldo();
            $Html =  $Parser->getTransaksiCredit(Date('Y-m-d',strtotime("-2 days")), Date('Y-m-d'));
            $Parser->logout();
            // echo $saldo[0]->saldo;
            foreach ($Html as $row) {
                $jj = count($row['description']) - 1;            
                $nominal_trf =(Int) str_replace(['.00',','],'',$row['description'][$jj]??0);
                $tgl = $row['date'];
                $dec = $row['description'][0].' '.$row['description'][1].' '.$row['description'][2];
                echo $nominal_trf."\n";
                $cek = Mts::where('tanggal',$tgl)->where('nominal',$nominal_trf)->where('deskripsi',$dec)->first();
                if(!$cek){
                    $mts            = new Mts();
                    $mts->rek       = $bank->no_rekening;
                    $mts->bank_id   = $bank->id;
                    $mts->tanggal   = $tgl;
                    $mts->deskripsi = $dec;
                    $mts->nominal   = $nominal_trf;
                    $mts->save();
                }
                
                $peserta    = Seminar::where('status',0)->where('total',$nominal_trf)->first();
                if($peserta){                    
                    $peserta->status        = '1';
                    $peserta->catatan       = 'Bank Otomatis';
                    $peserta->type_bayar    = 'Bank';
                    
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
                                    $komisi_total   = Seminar::where('ref',$peserta->ref)->where('kode_event',$peserta->kode_event)->where('status',1)->sum('fee_referal') ?? 0;
                                    $pengundang     = ["nama"=>$peserta->nama,"sapaan"=>$peserta->sapaan,"panggilan"=>$peserta->panggilan,"pengundang_nama"=>$ref->nama,"pengundang_sapaan"=>$ref->sapaan,"pengundang_panggilan"=>$ref->panggilan,"komisi"=>number_format($event->fee_referral),"komisi_total"=>number_format($komisi_total)];
                                    $cw_payment_ref = ReplaceArray($pengundang,$event->cw_payment_ref);
                                    $notif          = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$peserta->ref,"message"=>$cw_payment_ref,"engine"=>$event->notifikasi,"delay"=>1]);
                                }
                            }
                        }
                    }
                    $peserta->save();
                }
            }
        }
        
    }
}
