<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Notif;
use App\Models\Seminar;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 1;
        if (Auth::user()->role_id == 1) {
            $event  = Event::where('status', $status)->get();
        } else {
            $event  = Event::where('status', $status)->get();
        }
        $title      = "Event";
        return view('event.event', compact('event', 'title'));
    }

    public function baru(Request $request)
    {
        $notif  = Notif::get();
        $title  = "Event Baru";
        return view('event.eventbaru', compact('notif', 'title'));
    }

    public function edit(Request $request)
    {
        $event  = Event::where('id', $request->id)->first();
        $notif  = Notif::get();
        return view('event.eventedit', compact('event', 'notif'));
    }

    public function save(Request $request)
    {
        if ($request->id) {
            $event                  = Event::find($request->id);
        } else {
            $event                  = new Event();
        }
        if ($request->flayer) {
            $file                   = $request->file('flayer');
            $filepath               = 'uploads/';
            $fileName               = 'file_name' . time() . "." . $file->getClientOriginalExtension();
            $getClientOriginalName  = $file->getClientOriginalName();
            $file->move('uploads/', $fileName);
            $filename               = url('uploads/' . $fileName);
            $path_file              = 'uploads/' . $fileName;
            $event->flayer              = $filename;
        }

        $event->event_title         = $request->nama;
        $event->open_register       = $request->open;
        $event->kode_event          = "DNA-01";
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
        $event  = Event::where('id', $request->id)->delete();
        return redirect('/event')->with('Data Berhasil Dihapus!!!');
    }

    public function sertifikat(Request $request)
    {
        $event  = Event::get();
        return view('event.sertifikat', compact('event'));
    }

    public function download(Request $request)
    {
        $nama   = trim(strtoupper(Auth::user()->nama));
        $no     = 'NO: SGM/' . Auth::user()->id . '/' . date('m/Y');
        $file   = Auth::id() . '-' . time() . ".jpg";
        $img    = Image::make(public_path('assets/images/sertifsgm.png'));
        $j      = strlen($nama) / 2;
        // return $j;
        $x      = (2250) - (380 + 960 + ($j * 110));
        // return $x;
        // $x=960+380;
        // $x  = 2300;
        // $x  = 380;
        $img->text($nama, $x, 1000, function ($font) {
            $font->file(realpath('assets/font/AstroSpace.ttf'));
            $font->size(150);
        });
        $img->text(
            '27 Oktober 2021',
            1425,
            1240,
            function ($font) {
                $font->file(realpath('assets/font/Montserratmed.ttf'));
                $font->size(50);
            }
        );
        $name   = "sertikat-" . Date('DmY') . ".JPG";
        $img->save(public_path('images/sertifikat-' . $file));
        $user   = User::where('id', Auth::user()->id)->first();
        $file   = "images/sertifikat" . '-' . $file;
        return response()->download($file, $name);
    }

    public function cw(Request $request)
    {
        $cw     = ReplaceArray(Auth::user(), Setting::first()->cw);
        $cw2    = ReplaceArray(Auth::user(), Setting::first()->cw2);
        return view('event.copywriting', compact('cw', 'cw2'));
    }




    public function absen(Request $request, Event $event)
    {
        return view('event.absen', [
            'event' => $event,
            'peserta' => Seminar::sudahAbsen($event->kode_event)
        ]);
    }

    public function absenAdd(Request $request, Event $event)
    {
        $peserta = Seminar::firstPhone($request->id);
        if ($peserta) {
            $hadir = $peserta->update([
                'absen_at' => Carbon::now()
            ]);
            if ($hadir) {
                $peserta = Seminar::sudahAbsen($event->kode_event);
                return view('event.tbody-absen', [
                    'peserta' => $peserta
                ]);
            }
            return false;
        }
        return false;
    }

    public function pesertaHadir(Event $event)
    {
        $peserta = Seminar::sudahAbsen($event->kode_event);
        return view('event.tbody-absen', [
            'peserta' => $peserta
        ]);
    }

    public function tiket(Request $request, Event $event)
    {
        $seminar = Seminar::where('phone', $request->phone)
            ->where('kode_event', $event->kode_event)
            ->first();
        $qrcode = QrCode::size(300)->generate($seminar->phone);
        return view('event.tiket', [
            'peserta' => $seminar,
            'event' => $event,
            'qrcode' => $qrcode
        ]);
    }
}
