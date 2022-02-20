<?php

namespace App\Http\Controllers;

use App\Helpers\Cloudflare;
use App\Models\Absensi;
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
use App\Helpers\Notifikasi;
use App\Helpers\Whatsapp;
use App\Models\Device;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 1;
        if (Auth::user()->role_id == 1) {
            $event  = Event::where('status', $status)->orderBy('id','desc')->get();
        } else {
            $event  = Event::where('status', $status)->orderBy('id','desc')->get();
        }
        $title      = "Event";
        return view('event.event', compact('event', 'title'));
    }

    public function baru(Request $request)
    {
        $user   = User::where('role_id', 4)->get();
        $type   = Event::where('id', $request->id)->groupBy('type')->select('type')->get();
        $notif  = Device::get();
        $title  = "Event Baru";
        return view('event.eventbaru', compact('notif', 'title', 'type', 'user'));
    }

    public function edit(Request $request)
    {
        $user   = User::where('role_id', 4)->get();
        $type   = Event::where('id', $request->id)->groupBy('type')->select('type')->get();
        $event  = Event::where('id', $request->id)->first();
        $notif  = Device::get();
        return view('event.eventedit', compact('event', 'notif', 'type', 'user'));
    }

    public function save(Request $request)
    {
        if ($request->id) {
            $event                  = Event::find($request->id);
        } else {
            $event                  = new Event();
            $event->kode_event      = Str::random(5);
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
        $event->sub_domain          = $request->sub_domain;
        $event->close_register      = $request->close;
        $event->tgl_event           = $request->tanggal;
        $event->cw_register         = $request->pendaftaran;
        $event->cw_register2        = $request->pendaftaran2;
        $event->cw_referral         = $request->pendaftaran_ref;
        $event->cw_payment          = $request->pembayaran;
        $event->cw_payment_ref      = $request->pembayaran_ref;
        $event->cw_absen            = $request->absen;
        $event->mitra_id            = $request->mitra_id;
        $event->komisi_mitra        = $request->komisi_mitra;
        $event->cw_absen_ref        = $request->absen_ref;
        $event->cw_email_register   = $request->pendaftaran_email;
        $event->cw_email_payment    = $request->pembayaran_email;
        $event->harga               = $request->harga;
        $event->narasumber          = $request->narasumber;
        $event->tema                = $request->tema;
        $event->type                = $request->type;
        $event->lokasi              = $request->lokasi;
        $event->event_detail        = $request->event_detail;
        // return $event;
        $event->save();
        try {
            Cloudflare::add_dns($request->sub_domain);
        } catch (\Throwable $th) {
            //throw $th;
        }
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
            'peserta' => Absensi::with('seminar')->today($event->kode_event)->get()
        ]);
    }

    public function absenAdd(Request $request, Event $event)
    {
        $phone   = preg_replace('/^0/','62',$request->id);
        $peserta = Seminar::where('phone',$phone)->first();        
        if ($peserta) {
            $cekAbsen = Absensi::where('kode_event', $event->kode_event)->where('seminar_id', $peserta->id)->whereDate('created_at', Carbon::now())->first();            
            if (!$cekAbsen) {
                # Lakukan Absensi Kehadiran
                $hadir = Absensi::create([
                    'seminar_id' => $peserta->id,
                    'kode_event' => $event->kode_event,
                    "tgl_absen"=>Date('Y-m-d')
                ]);
                // $notif   = Notifikasi::send(["device_key"=>'8niD7OgjZ737XWh',"phone"=>$peserta->phone,"message"=>ReplaceArray($peserta,$event->cw_absen),"engine"=>'quods',"delay"=>1]);                    
                Whatsapp::send(["token"=>$event->device_id,"phone"=>$peserta->phone,"message"=>ReplaceArray($peserta,$event->cw_absen)]);
                if($peserta->ref){
                    $peng = Seminar::where('phone',$peserta->ref)->first();
                    if(!$peng){
                        $peng = User::where('phone',$peserta->ref)->first();
                    }
                    if($peng){
                        $pengundang = [
                            "ref_sapaan"=>$peng->sapaan,
                            "ref_nama"  =>$peng->nama,
                            "ref_panggilan"=>$peng->panggilan,
                            "nama"=>$peserta->nama,
                            "sapaan"=>$peserta->sapaan,
                            "panggilan"=>$peserta->panggilan,
                            "phone"=>$peserta->phone
                        ];
                        // $notif_ref = Notifikasi::send(["device_key"=>'8niD7OgjZ737XWh',"phone"=>$peng->phone,"message"=>ReplaceArray($pengundang,$event->cw_absen_ref),"engine"=>'quods',"delay"=>1]);                    
                        Whatsapp::send(["token"=>$event->device_id,"phone"=>$peng->phone,"message"=>ReplaceArray($pengundang,$event->cw_absen_ref)]);
                    }                    
                }
                return view('event.tbody-absen', [
                    'peserta' => Absensi::with('seminar')->today($event->kode_event)->get()
                ]);
            } else {
                # Sudah Pernah Absen
                return [
                    'status' => 'sudah-absen',
                    'phone' => $request->id
                ];
            }
        }else{
            return [
                'status' => 'tidak-ada',
                'phone' => $request->id
            ];
        }
    }

    public function pesertaHadir(Event $event)
    {
        $peserta = Absensi::with('seminar')->today($event->kode_event)->get();
        return view('event.tbody-absen', [
            'peserta' => $peserta
        ]);
    }

    public function tiketImg()
    {
        // $tiket = Browsershot::url('https://example.com')->setScreenshotType('jpeg', 100);
    }

    public function tiket(Request $request, Event $event)
    {
        $seminar = Seminar::phone($request->phone)
            ->where('kode_event', $event->kode_event)
            ->first();
        if ($seminar) {
            $qrcode = QrCode::size(250)->generate($seminar->phone);
        } else {
            $qrcode = null;
        }
        return view('event.tiket', [
            'peserta' => $seminar,
            'event' => $event,
            'qrcode' => $qrcode
        ]);
    }

    public function tiketall(Request $request)
    {
        $seminar = Seminar::phone($request->phone)->orderBy('id','desc')->first();
        $event   = Event::where('kode_event',$seminar->kode_event)->first() ?? null;
        if ($seminar) {
            $qrcode = QrCode::size(250)->generate($seminar->phone);
        } else {
            $qrcode = null;
        }
        return view('event.tiketall', [
            'peserta' => $seminar,
            'event' => $event,
            'qrcode' => $qrcode
        ]);
    }

    public function tiket2(Request $request, Event $event)
    {
        $seminar = Seminar::phone($request->phone)
            ->where('kode_event', $event->kode_event)
            ->first();
        if ($seminar) {
            try {
                $image = QrCode::format('png')
                    ->margin(10)
                    ->size(1000)->errorCorrection('H')
                    ->generate($seminar->phone);
                return response($image)->header('Content-type', 'image/png');
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        } else {
            return "data tidak ditemukan";
        }
    }

    public function pesertaDelete(Request $request, Event $event)
    {
        $absen = Absensi::where('id', $request->id)->first();        
        if ($absen) {            
            if ($absen) {
                $absen->delete();
            }
            $peserta = Absensi::where('kode_event',$event->kode_event)->get();
            return view('event.tbody-absen', [
                'peserta' => $peserta
            ]);
            return true;
        } else {
            return false;
        }
    }
}
