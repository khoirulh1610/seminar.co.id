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
use App\Models\Lfwuser;
use App\Models\Produk;
use App\Models\Zoom;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 1;
        if (Auth::user()->role_id == 1) {
            $event  = Event::where('status', $status)->orderBy('tgl_event', 'desc')->get();
        } else {

            $user_lfw   = Lfwuser::where('email', Auth::user()->email)->first();
            if ($user_lfw) {
                $cek_user   = User::where('email', $user_lfw->email)->first();
                if ($cek_user) {
                    $event  = Event::where('brand', 'lfw')->where('status', $status)->orderBy('tgl_event', 'desc')->get();
                } else {
                    $event  = Event::where('status', $status)->orderBy('tgl_event', 'desc')->get();
                }
            } else {
                if (Auth::user()->role_id == 2) {
                    $event  = Event::where('brand', Auth::user()->brand)->where('status', $status)->orderBy('tgl_event', 'desc')->get();
                } else {
                    $event  = Event::where('status', $status)->orderBy('tgl_event', 'desc')->get();
                }
            }
        }
        $title      = "Event";
        return view('event.event', compact('event', 'title'));
    }

    public function baru(Request $request)
    {
        $user       = User::where('role_id', 4)->get();
        $type       = Event::where('id', $request->id)->groupBy('type')->select('type')->get();
        $notif      = Device::get();
        $title      = "Event Baru";
        $produk_id  = Produk::get();
        $zoom_id    = Zoom::get();
        return view('event.eventbaru', compact('notif', 'title', 'type', 'user', 'produk_id', 'zoom_id'));
    }

    public function edit(Request $request)
    {
        $user       = User::where('role_id', 4)->get();
        $type       = Event::where('id', $request->id)->groupBy('type')->select('type')->get();
        $event      = Event::where('id', $request->id)->first();
        $notif      = Device::get();
        $produk_id  = Produk::get();
        $zoom_id    = Zoom::get();
        return view('event.eventedit', compact('event', 'notif', 'type', 'user', 'zoom_id', 'produk_id'));
    }

    public function save(Request $request)
    {
        if ($request->id) {
            $event                      = Event::where('id', $request->id)->first();
        } else {
            $event                      = new Event();
            $event->kode_event          = Str::random(5);
        }
        if ($request->flayer) {
            $file                       = $request->file('flayer');
            $filepath                   = 'uploads/';
            $fileName                   = 'file_name' . time() . "." . $file->getClientOriginalExtension();
            $getClientOriginalName      = $file->getClientOriginalName();
            $file->move('uploads/', $fileName);
            $filename                   = url('uploads/' . $fileName);
            $path_file                  = 'uploads/' . $fileName;
            $event->flayer              = $filename;
        }
        if ($request->flayer_fb) {
            $file                       = $request->file('flayer_fb');
            $filepath                   = 'uploads/';
            $fileName                   = 'file_name' . time() . "." . $file->getClientOriginalExtension();
            $getClientOriginalName      = $file->getClientOriginalName();
            $file->move('uploads/', $fileName);
            $filename                   = url('uploads/' . $fileName);
            $path_file                  = 'uploads/' . $fileName;
            $event->flayer_facebook     = $filename;
        }
        if ($request->flayer_ig) {
            $file                       = $request->file('flayer_ig');
            $filepath                   = 'uploads/';
            $fileName                   = 'file_name' . time() . "." . $file->getClientOriginalExtension();
            $getClientOriginalName      = $file->getClientOriginalName();
            $file->move('uploads/', $fileName);
            $filename                   = url('uploads/' . $fileName);
            $path_file                  = 'uploads/' . $fileName;
            $event->flayer_instagram    = $filename;
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
        $event->cw_tagihan          = $request->tagihan;
        $event->cw_absen            = $request->absen;
        $event->cw_facebook         = $request->cw_fb;
        $event->cw_instagram        = $request->cw_ig;
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
        $event->device_id           = $request->notif;
        $event->event_detail        = $request->event_detail;
        $event->link_zoom           = $request->link_zoom;
        $event->meeting_id          = $request->meet_id;
        $event->zoom_id             = $request->zoom_id;
        $event->produk              = $request->produk;
        $event->status              = $request->status;
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

    public function cw(Request $request, $kode_event)
    {
        $event = Event::where('kode_event', $kode_event)->first();
        $cw = '';
        $cw2 = '';
        return view('event.copywriting', compact('cw', 'cw2', 'event'));
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
        $phone   = preg_replace('/^0/', '62', $request->id);
        $peserta = Seminar::where('phone', $phone)->first();
        if ($peserta) {
            $cekAbsen = Absensi::where('kode_event', $event->kode_event)->where('seminar_id', $peserta->id)->whereDate('created_at', Carbon::now())->first();
            if (!$cekAbsen) {
                # Lakukan Absensi Kehadiran
                $hadir = Absensi::create([
                    'seminar_id' => $peserta->id,
                    'kode_event' => $event->kode_event,
                    "tgl_absen" => Date('Y-m-d')
                ]);
                // $notif   = Notifikasi::send(["device_key"=>'8niD7OgjZ737XWh',"phone"=>$peserta->phone,"message"=>ReplaceArray($peserta,$event->cw_absen),"engine"=>'quods',"delay"=>1]);                    
                Whatsapp::send(["token" => $event->device_id, "phone" => $peserta->phone, "message" => ReplaceArray($peserta, $event->cw_absen)]);
                if ($peserta->ref) {
                    $peng = Seminar::where('phone', $peserta->ref)->first();
                    if (!$peng) {
                        $peng = User::where('phone', $peserta->ref)->first();
                    }
                    if ($peng) {
                        $pengundang = [
                            "ref_sapaan" => $peng->sapaan,
                            "ref_nama"  => $peng->nama,
                            "ref_panggilan" => $peng->panggilan,
                            "nama" => $peserta->nama,
                            "sapaan" => $peserta->sapaan,
                            "panggilan" => $peserta->panggilan,
                            "phone" => $peserta->phone
                        ];
                        // $notif_ref = Notifikasi::send(["device_key"=>'8niD7OgjZ737XWh',"phone"=>$peng->phone,"message"=>ReplaceArray($pengundang,$event->cw_absen_ref),"engine"=>'quods',"delay"=>1]);                    
                        Whatsapp::send(["token" => $event->device_id, "phone" => $peng->phone, "message" => ReplaceArray($pengundang, $event->cw_absen_ref)]);
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
        } else {
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
        $seminar = Seminar::phone($request->phone)->orderBy('id', 'desc')->first();
        $event   = Event::where('kode_event', $seminar->kode_event)->first() ?? null;
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
            $peserta = Absensi::where('kode_event', $event->kode_event)->get();
            return view('event.tbody-absen', [
                'peserta' => $peserta
            ]);
            return true;
        } else {
            return false;
        }
    }



    public function ticket(Request $request, $subdomain, $phone)
    {
        $event = Event::firstWhere('sub_domain', $subdomain);
        if (!$event) abort(404);

        $peserta_seminar = Seminar::where('kode_event', $event->kode_event)->where('phone', $phone)->first();
        // dd($peserta_seminar);
        if (!$peserta_seminar) abort(404);

        // view Blade
        $view_blade = "ticket.{$subdomain}";

        // buat format file path from blade
        $view_path = resource_path("views/") . str_replace('.', '/', $view_blade) . ".blade.php";
        // cek file blade ada gak
        $view_exist = file_exists($view_path);
        // jika gak ada return 404
        if (!$view_exist) abort(404);

        // dd($peserta_seminar->status == 1);
        if ($peserta_seminar->status == 1) {
            $qr = "https://chart.googleapis.com/chart?chs=290&cht=qr&chl={$peserta_seminar->phone}&choe=UTF-8";
        } else {
            if ($peserta_seminar->total == 0) {
                $qr = "https://chart.googleapis.com/chart?chs=290&cht=qr&chl={$peserta_seminar->phone}&choe=UTF-8";
            } else {
                $qr = url('/ticket/qrcode.jpg');
            }
        }

        $absen = Absensi::where('seminar_id', $peserta_seminar->id)
            ->where('kode_event', $event->kode_event)
            ->whereDate('tgl_absen', Carbon::today())
            ->first();

        return view($view_blade, [
            'event' => $event,
            'lunas' => $peserta_seminar->total == 0 ? true : $peserta_seminar->status == 1,
            'peserta' => $peserta_seminar,
            'absen' => $absen ?? false,
            'qr' => $qr
        ]);
    }

    public function depan(Request $request)
    {
        # code...
        $status = 1;
        // if (Auth::user()->role_id == 1) {
        $event  = Event::where('status', 1)->orderBy('tgl_event', 'desc')->get();
        // } else {
        //     $user_lfw   = Lfwuser::where('email', Auth::user()->email)->first();
        //     $cek_user   = User::where('email', $user_lfw->email)->first();
        //     if($cek_user){
        //         $event  = Event::where('brand', 'lfw')->where('status', $status)->orderBy('tgl_event', 'desc')->get();
        //     } else {
        //         $event  = Event::where('status', $status)->orderBy('tgl_event', 'desc')->get();
        //     }
        // }
        $title      = "Event";
        return view('depan', compact('event', 'title'));
    }
}
