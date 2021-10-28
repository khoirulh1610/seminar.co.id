<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Notif;
use App\Models\Setting;
use App\Models\User;
use Intervention\Image\Facades\Image;
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
        $title      = "Event";
        return view('event.event',compact('event','title'));
    }

    public function baru(Request $request)
    {
        $notif  = Notif::get();
        $title  = "Event Baru";
        return view('event.eventbaru',compact('notif','title'));
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

    public function sertifikat(Request $request)
    {
        $event  = Event::get();
        return view('event.sertifikat',compact('event'));
    }

    public function download(Request $request)
    {
        $nama   = trim(strtoupper(Auth::user()->nama));
        $no     = 'NO: SGM/'.Auth::user()->id.'/'.date('m/Y');
        $file   = Auth::id().'-'.time().".jpg";
        $img    = Image::make(public_path('assets/images/sertif.png'));  
        $j      = strlen($nama)/2;
        $x      = 2600-(100*$j);
        $img->text($nama, $x, 2000, function($font) {
            $font->file(realpath('assets/font/AstroSpace.ttf'));
            $font->size(300);
        });
        $img->text('27 Oktober 2021',
            2900, 2505, function($font) {
            $font->file(realpath('assets/font/Myriad.ttf'));
            $font->size(100);
        });
        $name   = "sertikat-".Date('DmY').".JPG";
        $img->save(public_path('images/sertifikat-'.$file)); 
        $user   = User::where('id',Auth::user()->id)->first();
        $file   = "images/sertifikat".'-'.$file; 
        return response()->download($file,$name);
    }

    public function cw(Request $request)
    {   
        $cw     = ReplaceArray(Auth::user(),Setting::first()->cw);
        $cw2    = ReplaceArray(Auth::user(),Setting::first()->cw2);  
        return view('event.copywriting',compact('cw','cw2'));
    }
}
