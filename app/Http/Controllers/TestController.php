<?php

namespace App\Http\Controllers;

use App\Mail\NotifMail;
use App\Models\Event;
use App\Models\Lfwuser;
use App\Models\Mitra;
use App\Models\Seminar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function index()
    {
        $user = User::find(2);
        // $mitra = Mitra::find(1);

        // dd($user->assignMitra($mitra));
        // dd($user->dropMitra('lfw'));
    }


    public function mail(Request $request)
    {
        $email  =  Mail::to('madeheri14@gmail.com')->cc(config('mail.to.cc'))->send(new NotifMail([
            "title"     => "Selamat Anda Berhasil Mendaftar di ",
            "content"   => "test",
            "header"    => "dikirim oleh sistem",
            "footer"    => ".seminar.co.id"
        ], "Anda Berhasil Mendaftar di"));
        return $email;
    }

    public function dashview(Request $request)
    {

        // if ($request->ajax()) {
        //     $event_m      = Event::where('mitra_id', Auth::user()->phone)->pluck('kode_event');
        //     if (Auth::user()->role_id == 1) {
        //         $event    = Event::where('status', 1)->orderBy('tgl_event', 'desc')->get();
        //         $seminar          = Seminar::all();
        //         $absen            = Absensi::all();
        //     } elseif (Auth::user()->role_id == 2) {
        //         $event        = Event::where('mitra_id', Auth::id())->orderBy('tgl_event', 'desc')->get();
        //         $seminar      = Seminar::whereIn('kode_event', $event_m)->get();
        //         $absen        = Absensi::whereIn('kode_event', $event_m)->get();
        //     } else {
        //         $pluck        = Seminar::where('ref', Auth::user()->phone)->pluck('kode_event');
        //         $seminar_id   = Seminar::where('ref', Auth::user()->phone)->pluck('id');
        //         $event        = Event::where('status', 1)->whereIn('kode_event', $pluck)->get();
        //         $seminar      = Seminar::where('ref', Auth::user()->phone)->get();
        //         $absen        = Absensi::whereIn('seminar_id', $seminar_id)->get();
        //         // return $absen->count();
        //     }
        //     $komisi           = Komisi::where('pengundang_phone', Auth::user()->phone)->get();
        //     $komisi_mitra     = Komisi::where('mitra_id', '212')->get();
        //     $title = "Dashboard";
        //     return view('dashview', compact('seminar', 'event', 'title', 'absen', 'komisi', 'komisi_mitra', 'event_m'));
        // }
    }




    public function betaPage()
    {
        return view('beta-menu');
    }
}
