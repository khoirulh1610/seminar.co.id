<?php

namespace App\Console\Commands;

use App\Helpers\Whatsapp;
use App\Models\Seminar;
use Illuminate\Console\Command;

class resendnotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resendnotif';

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
        $seminar = Seminar::where('created_at','>=',date('y-m-d'))->whereNull('att1')->get();
        foreach($seminar as $s){
            if($s->message){
                $kirim = Whatsapp::send([
                    "token"=>"3",
                    "phone"=> $s->phone,
                    "message"=> $s->message,
                    "file_url"=>'',
                ]);
            }
            if($s->message2){
                $kirim = Whatsapp::send([
                    "token"=>"3",
                    "phone"=> $s->phone,
                    "message"=> $s->message2,
                    "file_url"=>'',
                ]);
            }            
            Seminar::where('id',$s->id)->update(['att1'=>'SENT']);
            echo $s->phone."\r\n";
        }
    }
}
