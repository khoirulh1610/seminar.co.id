<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Notif;
use Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->role_id==1){
            $event  = Event::get();
        }else{
            $event  = Event::where('brand',Auth::user()->brand)->get();
        }
        return view('event.event',compact('event'));
    }

    public function baru(Request $request)
    {
        $notif  = Notif::get();
        return view('event.eventbaru',compact('notif'));
    }

    public function edit(Request $request)
    {   
        $event  = Event::where('id',$request->id)->first();
        $notif  = Notif::get();
        return view('event.eventedit',compact('event','notif'));
    }

    public function save(Request $request)
    {   
        if($request->id){
            $event                  = Event::find($request->id);
        }else{
            $event                  = new Event();
        }
        
        if($request->flayer){
            $file                   = $request->file('flayer');
            $filepath               = 'uploads/';
            $fileName               = 'file_name'.time().".".$file->getClientOriginalExtension();
            $getClientOriginalName  = $file->getClientOriginalName();
            $file->move('uploads/',$fileName);
            $filename               = url('uploads/'.$fileName);       
            $path_file              = 'uploads/'.$fileName;  
            $event->flayer              = $filename;   
        }
        
        $event->event_title         = $request->nama; 
        $event->open_register       = $request->open;
        $event->kode_event          = "SGM-01";
        $event->close_register      = $request->close;
        $event->tgl_event           = $request->tanggal;
        $event->cw_register         = $request->pendaftaran;
        $event->cw_payment          = $request->pembayaran;
        $event->cw_email_register   = $request->pendaftaran2;
        $event->cw_email_payment    = $request->pembayaran2;
        $event->harga               = $request->harga;
        $event->narasumber          = $request->narasumber;
        $event->tema                = $request->tema;
        $event->save();

        // return $event;
        return redirect('/event');
    }

    public function hapus(Request $request)
    {
        $event  = Event::where('id',$request->id)->delete();
        return redirect('/event')->with('Data Berhasil Dihapus!!!');        
    }
}
