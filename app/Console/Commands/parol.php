<?php

namespace App\Console\Commands;

use App\Models\Komisi;
use App\Models\Produk;
use App\Models\Seminar;
use Illuminate\Console\Command;

class parol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parol';

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
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://parol.id/api/member",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $json =  json_decode($response);
            foreach ($json as $j) {
                $phone = preg_replace('/^0/','62',$j->phone);
                $seminar = Seminar::where('phone',$phone)->first();
                if($seminar){
                    $produk = Produk::where('id',1)->first();
                    if($produk){
                        $cek  = Komisi::where('produk_id',1)->where('pembeli_phone',$phone)->first();
                        if(!$cek){
                            $komisi = new Komisi();
                            $komisi->produk_id          = 1;
                            $komisi->keterangan         = "Komisi Pendaftaran Akun Parol";
                            $komisi->tanggal            = $j->tanggal;
                            $komisi->harga              = $j->total_pembayaran;
                            $komisi->komisi             = $produk->komisi;
                            if( $j->total_pembayaran>380000 &&  $j->total_pembayaran <= 420000){
                                $komisi->komisi_mitra   = 150000;
                            }
                            $komisi->pembeli_phone      = $phone;
                            $komisi->pengundang_phone   = $seminar->ref ?? 'System';
                            $komisi->pengundang_nama    = $seminar->pengundang->nama ?? 'System';
                            $komisi->save();
                        }
                    }
                }
            }
        }
    }
}
