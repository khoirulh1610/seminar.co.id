<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Whatsapp;

class InfoServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'InfoServer';

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
        $notif = Whatsapp::send(["token" => "3", "phone" => "6281228060666-1635994060@g.us", "message" => "Info server whatsapp from https://seminar.co.id"]);
            $notif = Whatsapp::send(["token" => "35", "phone" => "6281228060666-1635994060@g.us", "message" => "Info server whatsapp from https://seminar.co.id"]);    
    }
}
