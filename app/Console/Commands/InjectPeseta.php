<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PesertaInject;
use App\Helpers\HelperZoom;
use Illuminate\Support\Facades\DB;

class InjectPeseta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inject:peserta';

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
        $peserta = PesertaInject::whereNull('link_zoom')->get();
        foreach ($peserta as $p) {
            try {
                $sapaan = $p->sapaan;
                $nama   = $p->nama;
                $email  = $p->email;            
                $link   = HelperZoom::join($sapaan,$nama,$email,'81935664235');
                echo $sapaan.$nama.$email."=>".$link."\r\n";
                PesertaInject::where('id',$p->id)->update(["link_zoom"=>$link]);
                // sleep(rand(1,3));
            } catch (\Throwable $th) {
                PesertaInject::where('id',$p->id)->update(["link_zoom"=>'-']);
            }
        }
    }
}
