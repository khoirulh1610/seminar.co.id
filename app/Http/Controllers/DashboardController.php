<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Event;
use App\Models\Komisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $event_m      = Event::where('mitra_id',Auth::id())->pluck('kode_event');
        if(Auth::user()->role_id==1){
            $event    = Event::where('status',1)->orderBy('tgl_event', 'desc')->get();
            $seminar          = Seminar::all();
            $absen            = Absensi::all();
        }elseif(Auth::user()->role_id==2){
            $event        = Event::where('mitra_id',Auth::id())->orderBy('tgl_event', 'desc')->get();            
            $seminar      = Seminar::whereIn('kode_event',$event_m)->get();
            $absen        = Absensi::whereIn('kode_event',$event_m)->get();            
        } else{
            $pluck        = Seminar::where('ref',Auth::user()->phone)->pluck('kode_event');
            $seminar_id   = Seminar::where('ref',Auth::user()->phone)->pluck('id');
            $event        = Event::where('status',1)->whereIn('kode_event',$pluck)->get();
            $seminar      = Seminar::where('ref',auth::user()->phone)->get();
            $absen        = Absensi::whereIn('seminar_id',$seminar_id)->get(); 
        }
        $komisi           = Komisi::where('pengundang_phone',Auth::user()->phone)->get();
        $komisi_mitra     = Komisi::where('mitra_id',Auth::id())->get();
        $title = "Dashboard";
        return view('dashboard',compact('seminar','event','title','absen','komisi','komisi_mitra','event_m'));
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

}
