<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Models\Seminar;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Access;
use App\Models\Event;
use App\Models\Bank;
use App\Models\Setting;
use App\Mail\RegistrasiMail;
use Illuminate\Support\Facades\Mail;

class RegisterMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public $event_id;
    public $seminar_id;
    public function __construct($event_id,$seminar_id)
    {
        $this->event_id = $event_id;
        $this->seminar_id = $seminar_id;        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $event = Event::where('id',$this->event_id)->first();
        if($event){
            $seminar = Seminar::where('id',$this->seminar_id)->first();
            if($seminar){
                $message = ReplaceArray((array)$seminar,$event->cw_email_register);
                Mail::to($seminar->email)->send(new RegistrasiMail(["title"=>$event->event_title ?? 'SEMINAR',"body"=>$message]));
            }
        }
    }
}
