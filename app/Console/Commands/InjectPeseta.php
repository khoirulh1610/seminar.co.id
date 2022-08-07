<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PesertaInject;
use App\Helpers\HelperZoom;
use App\Models\Event;
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
            $event              = Event::where('id', $p->event_id)->first();
            sleep(rand(1, 3));
            try {
                $sapaan         = $p->sapaan;
                $nama           = $p->panggilan.', '.$p->kota;
                $email          = $p->email;
                $zoom_id        = $event->zoom_id;
                $meeting_id     = $event->meeting_id;
                // $link           = HelperZoom::join(2, $sapaan, $nama, $email, '95053083168');
                $link           = HelperZoom::join($zoom_id, $sapaan, $nama, $email, $meeting_id);
                echo $email . "=>" . $link . "\r\n";
                PesertaInject::where('id', $p->id)->update(["link_zoom" => $link ?? null]);
            } catch (\Throwable $th) {
                PesertaInject::where('id', $p->id)->update(["link_zoom" => null]);
            }
        }
    }
}
