<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Event;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role_id==1){
            $event    = Event::where('status',1)->get();
        }else{
            $pluck = Seminar::where('ref',Auth::user()->phone)->pluck('kode_event');
            $event    = Event::where('status',1)->whereIn('kode_event',$pluck)->get();
        }
        
        $seminar  = Seminar::get();
        // return $pluck;

        $title = "Dashboard";
        return view('dashboard',compact('seminar','event','title'));
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

}
