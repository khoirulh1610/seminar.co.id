<?php

namespace App\Http\Controllers;

use App\Helpers\HelperZoom;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminar;
use App\Models\Notifikasi as WaNotif;
use App\Helpers\Notifikasi;
use App\Helpers\Whatsapp;
use App\Mail\NotifMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Absensi;
use App\Models\Access;
use App\Models\Device;
use App\Models\Kabupaten;
use App\Models\ListPolling;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\TransaksiSeminar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class DaftarEventController extends Controller
{
    public function index(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();

        if ($request->ref) {
            Cookie::queue('kode_ref', $request->ref, 1 * 60 * 24 * 30);
        }
        if (!$event) {
            return abort(404, 'Halaman tidak ditemukan');
        }
        if ($event->close_register <= Carbon::now()) {
            $event2   = Event::where('brand', $event->brand)->orderBy('id', 'desc')->first();
            // return $event;
            if ($event2) {
                if ($event2->close_register <= Carbon::now()) {
                    return abort(403, 'REGISTRASI DITUTUP');
                }
                return redirect("https://" . $event2->sub_domain . ".seminar.co.id/?ref=" . $request->ref);
            }
            return abort(403, 'REGISTRASI DITUTUP');
        }
        $ref = $request->ref ?? request()->cookie('kode_ref') ?? '';
        $pengndang = User::where('phone', $ref)->orWhere('kode_ref', $ref)->whereNotNull('kode_ref')->first();

        // Log::info('pngndang', [$pengndang]);
        if (!$pengndang) {
            if ($ref) {
                $ref = preg_replace('/^0/', '62', $ref);
                $pengndang = Seminar::where('phone', $ref)->first();
            }
        }

        $pengundang_nama    = $pengndang->nama ?? '';
        $pengundang_sapaan  = $pengndang->sapaan ?? 'Pak';
        $pengundang_panggilan  = $pengndang->panggilan ?? 'Admin';

        $device = Device::where('id', $event->device_id)->first();
        $pengundang_phone   = $ref ? preg_replace('/^0/', '62', $ref) : $device->phone ;
        $buka_pendaftaran   = 1;
        $link  = "https://api.whatsapp.com/send/?phone=" . $pengundang_phone . "&text=✏️+" . $pengundang_sapaan . "+" . $pengundang_panggilan . "+ %0AMohon+data+dibawah+ini+tolong+didaftarkan%0ASaya+butuh+bantuan,+pendaftaran+di %0A" . url('/') . "?ref=" . $pengundang_phone . " %0A%0ABerikut ini data saya+: %0ANama+: %0AEmail+: %0ANo Hp+: %0ATgl Lahir+: %0AKota/Kab+:";
        // $link2 = "https://api.whatsapp.com/send/?phone=".$pengundang_phone."&text=Saya+butuh+bantuan,+pendaftaran+di+" . url('/') . " %0A%0ABerikut ini data saya+: %0ANama+: %0AEmail+: %0ANo hp+: %0ATgl lahir+: %0AKota/kab+:";
        $produk = Produk::where('name', $event->produk)->first();

        $view = 'DaftarEvent.index';
        if ($produk) {
            if ($produk->template !== 'default') {
                $view = $produk->template;
            }
        }
        return view($view, compact('pengundang_nama', 'buka_pendaftaran', 'event', 'link'));
    }

    public function absen()
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();
        $provinsi = Provinsi::all();
        $kota  = Kabupaten::all();
        return view('DaftarEvent.absen', compact('event', 'provinsi', 'kota'));
    }

    public function absen_save(Request $request)
    {
        if ($request->reg_absen) {
            $cek = Seminar::where('kode_event', $request->kode_event)->where(function ($s) use ($request) {
                $s->where('phone', $request->phone)->orWhere('email', $request->email);
            })->first();

            if (!$cek) {
                $seminar = new Seminar();
                $seminar->kode_event = $request->kode_event;
                $seminar->sapaan = $request->sapaan;
                $seminar->nama = $request->nama;
                $seminar->panggilan = $request->panggilan;
                $seminar->phone = preg_replace('/^0/', '62', $request->phone);
                $seminar->email = $request->email;
                $seminar->prov_id = $request->prov_id;
                $seminar->provinsi = Provinsi::where('id', $request->prov_id)->first()->name ?? '';
                $seminar->kota_id = $request->kota_id;
                $seminar->kota = Kabupaten::where('id', $request->kota_id)->first()->name ?? '';
                $seminar->tgl_seminar = Date('Y-m-d');
                $seminar->profesi = $request->profesi;
                $seminar->save();
            }
        }
        $phone = preg_replace('/^0/', '62', $request->phone);
        $seminar = Seminar::where('phone', $phone)->orderBy('id', 'desc')->first();
        if ($seminar) {
            $cek   = Absensi::where('seminar_id', $seminar->id)->where('tgl_absen', Date('Y-m-d'))->first();
            if (!$cek) {
                $absen = new Absensi();
                $absen->seminar_id = $seminar->id;
                $absen->kode_event = $request->kode_event ?? $seminar->kode_event;
                $absen->tgl_absen  = Date('Y-m-d');
                $absen->save();
                $event = Event::where('kode_event', $request->kode_event)->first();
                if ($event) {
                    $cw = ReplaceArray($seminar, $event->cw_absen);
                    $kirim = Whatsapp::send(['token' => 3, 'phone' => $seminar->phone, 'message' => $cw]);
                    if ($seminar->ref) {
                        $ref_seminar = Seminar::where('phone', $seminar->ref)->first();
                        if ($ref_seminar) {
                            // Log::debug($ref_seminar);
                            $cw_ref_data = ['phone' => $seminar->phone, 'ref_panggilan' => $ref_seminar->panggilan ?? $ref_seminar->nama, 'ref_sapaan' => $ref_seminar->sapaan, 'nama' => $seminar->nama];
                            $cw_ref      = ReplaceArray($cw_ref_data, $event->cw_absen_ref);
                            $d = Whatsapp::send(['token' => 3, 'phone' => $ref_seminar->phone, 'message' => $cw_ref]);
                            $j = Absensi::where('kode_event', $request->kode_event)->count();
                            $e = Whatsapp::send(['token' => 3, 'phone' => $event->group_info, 'message' => $cw_ref]);
                            // Log::info($d);
                        }
                    }
                    return redirect('absen?message=Selamat Absen sudah berhasil');
                }
            } else {
                return redirect('absen?message=Anda sudah Absen sebelumnya');
            }
        } else {
            return redirect('absen?register=Y');
        }
    }

    public function kabupaten()
    {
        $kab = file_get_contents("./data/kabupaten.json");
        if (isset($_GET['id'])) {
            $data = json_decode($kab);
            $province_id = $_GET['id'] ?? '';
            foreach ($data as $k) {
                if ($k->province_id == $province_id) {
                    echo '<option value="' . $k->id . '">' . $k->full_name . '</option>';
                }
            }
        } else {
            $data = json_decode($kab);
            foreach ($data as $k) {
                echo '<option value="' . $k->id . '">' . $k->full_name . '</option>';
            }
        }
    }

    public function register(Request $request)
    {
        $Access = new Access();
        $Access->nama = $request->nama;
        $Access->phone = $request->phone;
        $Access->email = $request->email;
        $Access->user_agent = $request->header('User-Agent');
        $Access->ip = $request->ip();
        // dd($request->ip());
        $Access->save();

        // Log::info($request->all());

        $nama       = $request->nama;
        $email      = strtolower($request->email);
        $phone      = preg_replace('/^0/', '62', $request->phone);
        $phone      = preg_replace('/\D/', '', $phone);

        // device 3, 7 yang digunakan
        $device_admin_checker = Device::whereIn('id', [3, 7])->where('status', 'AUTHENTICATED')->first();
        if ($device_admin_checker) {
            $data = [
                'token' => "{$device_admin_checker->id}",
                'phone' => $phone,
            ];
            // $isWA_respon = Whatsapp::isWA($data);
            // if (!($isWA_respon['status'] ?? true)) {
            //     return redirect()->back()->with('warning', "Nomor '{$phone}' tidak terdaftar whatsapp");
            // }
        }

        $provinsi   = $request->provinsi;
        $kab        = $request->kota;
        $kota       = DB::table('kabupatens')->where('id', $kab)->first()->full_name ?? DB::table('kabupatens')->where('id', $kab)->first()['full_name'] ?? '';
        $profesi    = $request->profesi;
        $ref        = $request->ref ?? 'admin';
        $referal    = User::where('kode_ref_lfw', $ref)
            ->orWhere('kode_ref', $ref)
            ->orWhere('phone', $ref)
            ->first();
        if (!$referal) {
            if ($ref) {
                $ref        = preg_replace('/^0/', '62', $ref);
            }
            $referal = Seminar::where('phone', $ref)->first();
        }
        // Log::info($referal);
        $panggilan  = $request->panggilan;
        $sapaan     = $request->sapaan;
        $kode_event = $request->kode_event;
        $b_tanggal  = $request->tanggal;
        $b_bulan    = $request->bulan;
        $b_tahun    = $request->tahun;
        $event      = Event::where('kode_event', $kode_event)->first();
        if (!$event) {
            // return ['status'=>false,"message"=>"Event Not Found"];
            return redirect()->back()->with(['message' => 'Event Tidak ada', 'status' => 1]);
        }
        $cek        = Seminar::where('email', $email)->where('kode_event', $kode_event)->where('tgl_seminar', $event->tgl_event)->first();
        if (!$cek) {
            $cek        = Seminar::where('phone', $phone)->where('kode_event', $kode_event)->where('tgl_seminar', $event->tgl_event)->first();
        }
        if ($cek) {
            if ($cek->status == 1) {
                // Notif sudah daftar & bayar
                $message    =  "Email Sudah Terdaftar & Pembayaran Lunas";
                // $notif      = Wa::Notif($phone,$message);
            } else if ($cek->status == 0) {
                // Notif sudah daftar belum bayar
                $message    = "Email Sudah Terdaftar & Pembayaran Belum Lunas";
                // $notif      = Wa::Notif($phone,$message);
            }
            // return redirect()->back()->with('error','Data Hp :'.$phone.' Email : '.$email.' Sudah terdaftar, Gunakan email yg lain');
            if ($event->type == 'gratis') {
                $message    = "Email / Phone Sudah Terdaftar" . $cek->phone . " " . $cek->email . " " . $cek->kode_event;
            }
            return redirect()->back()->with(['message' => $message, 'status' => 1]);
        } else {
            $harga      = $event->harga ?? 0;
            $unix       = rand(1, 999) ?? 0;
            $total      = ($harga > 0 ? $harga + $unix : 0);
            // try {
            $join_zoom                  = $event->meeting_id ? (HelperZoom::join($event->zoom_id, $sapaan, $panggilan . ', ' . $kota, $email, $event->meeting_id) ?? $event->link_zoom ?? null) : null;
            $ary                        = ["nama" => $nama, "email" => $email, "total" => 'Rp. ' . number_format($total, 0), "phone" => $phone, "provinsi" => $provinsi, "sapaan" => $sapaan, "tgl_seminar" => $event->tanggal, "panggilan" => $panggilan, "profesi" => $profesi, "ref" => $ref, "kota" => $kota, 'join_zoom' => $join_zoom];
            $message                    = ReplaceArray($ary, $event->cw_register);
            $message2                   = false;
            if ($event->cw_register2) {
                $message2                    = ReplaceArray($ary, $event->cw_register2);
            }
            $seminar                    = new Seminar();
            $seminar->sapaan            = $sapaan;
            $seminar->panggilan         = $panggilan;
            $seminar->nama              = $nama;
            $seminar->email             = $email;
            $seminar->phone             = $phone;
            $seminar->profesi           = $profesi;
            $seminar->prov_id           = $provinsi;
            $seminar->provinsi          = DB::table('provinsis')->where('id', $provinsi)->first()->name ?? DB::table('provinsis')->where('id', $provinsi)->first()['name'] ?? '';
            $seminar->kota_id           = $kab;
            $seminar->kota              = $kota;
            $seminar->harga             = $harga;
            $seminar->unix              = $unix;
            $seminar->total             = $total;
            $seminar->status            = 0;
            $seminar->message           = $message;
            $seminar->message2          = $message2 ?? null;
            $seminar->tgl_seminar       = $event->tgl_event;
            $seminar->kode_event        = $kode_event;
            $seminar->fee_referral      = $event->fee_referral ?? 0;
            $seminar->fee_admin         = $event->fee_admin ?? 0;
            $seminar->b_tanggal         = $b_tanggal;
            $seminar->b_bulan           = $b_bulan;
            $seminar->b_tahun           = $b_tahun;
            $seminar->join_zoom         = $join_zoom;
            $seminar->jabatan           = $request->jabatan ?? null;
            $seminar->bidang_usaha      = $request->bidang_usaha ?? null;


            // Ambil data terakhir dari ikut event-nya
            $peserta = Seminar::where('phone', $phone)->orderBy('id', 'DESC')->first();
            $ref_exp = $peserta ? $peserta->ref_exp : null;
            $exp_produk_peserta = Carbon::parse($ref_exp)->second(0);
            // Log::info('EXP lama', [$exp_produk_peserta, $peserta->id]);
            $now = Carbon::now();

            $produkku = $event->product;

            // jika tgl exp_produk_peserta sudah lewat, maka atur ulang
            if ($exp_produk_peserta->lt($now)) {
                // Bisa ganti refferalnya
                $seminar->ref = $referal->phone ?? $ref ?? null;

                // Atur ulang tgl exp_produk_peserta jika ada
                if ($produkku) {
                    $expRef = $produkku->exp_referral;
                    if ($expRef !== null) {
                        // Ganti ke baru
                        $seminar->ref_exp = Carbon::now()->addMonths($expRef);
                    }
                }
            } else {
                // Tidak bisa ganti refferalnya (yang lama dipakai)
                $seminar->ref = $referal->phone ?? $peserta->ref ?? $ref  ?? null;
                $seminar->ref_exp = $peserta->ref_exp;
            }

            $seminar->ref_pertama = $referal->ref_pertama ?? null;

            $seminar->save();
            // Notifikasi ke peserta                 
            $WaNotif                = new WaNotif();
            $WaNotif->kode_event    = $kode_event;
            $WaNotif->phone         = $phone;
            $WaNotif->notif         = $message;
            $WaNotif->judul         = "Notifikasi user daftar";
            $WaNotif->nama          = $nama;
            $WaNotif->save();

            // $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message,"engine"=>$event->notifikasi,"delay"=>0]);                    
            // if($message2){
            //     $notif2                 = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>$phone,"message"=>$message2,"engine"=>$event->notifikasi,"delay"=>0]);
            // }
            // $notif                      = Notifikasi::send(["device_key"=>$event->notifikasi_key,"phone"=>'120363023657414562@g.us',"message"=>$message,"engine"=>$event->notifikasi,"delay"=>1]);

            $notif1 =  Whatsapp::send([
                "token"     => $event->device_id,
                "phone"     => $phone,
                "message"   => $message
            ]);
            if ($message2) {
                $notif2 =  Whatsapp::send([
                    "token"     => $event->device_id,
                    "phone"     => $phone,
                    "message"   => $message2
                ]);
            }

            // try {
            //     Mail::to($email)->send(new NotifMail([
            //         "title" => "Selamat Anda Berhasil Mendaftar di $event->event_title",
            //         "content" => "test",
            //         "header" => "dikirim oleh sistem",
            //         "footer" => "{$event->sub_domain}.seminar.co.id"
            //     ], "Anda Berhasil Mendaftar di $event->event_title"));
            // } catch (\Throwable $th) {
            //     Log::error("[MAIL] {$th->getMessage()} at " . __FILE__ . ":" . __LINE__);
            // }

            // $notif3 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>'6289514010645-1635994060@g.us',"message"=>$message]);

            // web Notif
            $data = [
                "title" => "Pendaftar Seminar " . $kode_event,
                "body" => "Nama : " . $nama . " Email : " . $email
            ];
            $webnotif = Notifikasi::fcmAll($data);
            // Notifikasi Ke Pengundang
            if ($referal) {
                if ($event->cw_referral) {
                    $jumlah_undangan = Seminar::where('ref', $referal->phone)->where('kode_event', $kode_event)->count();
                    $ary2            = [
                        "nama" => $nama,
                        "email" => $email,
                        "total" => number_format($total, 0),
                        "phone" => $phone,
                        "provinsi" => $provinsi,
                        "sapaan" => $sapaan,
                        "profesi" => $profesi,
                        "tgl_seminar" => $event->tanggal,
                        "panggilan" => $panggilan,
                        "ref" => $ref,
                        "kota" => $kota,
                        "jumlah_undangan" => $jumlah_undangan,
                        "pengundang_sapaan" => $referal->sapaan ?? null,
                        "pengundang_nama" => $referal->nama ?? null,
                        "pengundang_panggilan" => $referal->panggilan ?? null,
                    ];
                    $cw_referral  = ReplaceArray($ary2, $event->cw_referral);
                    $WaNotif = new WaNotif();
                    $WaNotif->phone = $ref;
                    $WaNotif->notif = $cw_referral;
                    $WaNotif->kode_event = $kode_event;
                    $WaNotif->judul = "Notifikasi user daftar ke pengundang";
                    $WaNotif->nama  = $referal->nama ?? null;
                    $WaNotif->save();
                    // $notif           = Notifikasi::send(["device_key" => $event->notifikasi_key, "phone" => $referal->phone, "message" => $cw_referral, "engine" => $event->notifikasi]);
                    // $notif_g         = Notifikasi::send(["device_key" => $event->notifikasi_key, "phone" => '6289514010645-1635994060@g.us', "message" => $cw_referral, "engine" => $event->notifikasi]);
                    $notif4 =  Whatsapp::send([
                        "token" => $event->device_id,
                        "phone" => $referal->phone,
                        "message" => $cw_referral
                    ]);
                    $notif5 =  Whatsapp::send([
                        "token" => $event->device_id,
                        "phone" => $event->group_info,
                        "message" => '*Info Group :*' . $cw_referral
                    ]);
                    //                                 $notif5 =  Whatsapp::send(["token"=>$event->device_id,"phone"=>'120363042484148885@g.us',"message"=>'*Info Group :*
                    // '.$cw_referral]);
                }
            }

            // return ['status'=>true,"message"=>$message,"ref"=>$ref];
            return redirect('/')->with(['message' => $message, 'status' => 1]);
            // } catch (\Throwable $th) {
            //     return ['status'=>false,"message"=>'Register Failed : '.$th->getMessage()];
            // }          

        }
    }

    public function daftar_akun(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();
        if (!$event) {
            return redirect('/');
        }
        $list = [];
        if($event->produk=='maxwin'){
            $list = ListPolling::group('maxwin')->get();
        }
        
        $provinsi = Provinsi::orderBy('name')->get();
        $kota  = Kabupaten::orderBy('name')->get();
        if ($request->phone) {
            $phone = formatPhone($request->phone);
            $data = Seminar::where('phone', $phone)->orderBy('id','desc')->first();
            if ($data === null) return redirect()->back()->with('warning', 'Nomor tidak terdaftar');
        }
        return view('DaftarEvent.daftar', [
            'provinsi' => $provinsi,
            'event' => $event,
            'kota' => $kota,
            'list' => $list,
            'data' => $data ?? null,
            'produk' => $event->produk
        ]);
    }

    public function daftar_akun_save(Request $request)
    {
        $request->validate([
            'jkel' => 'required',
            // 'no_ktp' => 'required|numeric',
            'thn' => 'required',
            'alamat' => 'required|min:10',            
        ], [
            'jkel.required' => 'Anda Belum memilih Jenis Kelamin',
            // 'no_ktp.required' => 'No KTP Harus diisi',
            // 'no_ktp.numeric' => 'No KTP Harus berisi angka',
            'thn.required' => 'Tahun lahir wajib diisi',
            'alamat.required' => 'Alamat Harus diisi',            
            'alamat.min' => 'minimal panjang Alamat setidaknya 10 karakter',
        ]);

        // cek event
        $event = Event::firstWhere('kode_event', $request->kode_event);        
        if (!$event) {
            return redirect()->back()->withErrors(['event-not-found' => 'Event Tidak ditemukan']);
        }
        if($event->produk=='maxwin'){
            $request->validate([
                'list' => 'required',
            ], [
                'list.required' => 'Setidaknya anda harus memilih satu program kami',
            ]);
        }

        if($event->produk=='tp'){
            $request->validate([
                'paket' => 'required',
            ], [
                'paket.required' => 'Anda belum memilih paket',
            ]);
        }
        // cek registrasi
        $cek = TransaksiSeminar::where('kode_event', $event->kode_event)->where(function ($q) use ($request) {
            $q->where('phone', $request->phone);
            $q->orWhere('email', $request->email);
        })->first();
        if ($cek) {


            //ulang notif
            $resWAx = Whatsapp::send([
                'token' => $event->device_id ?? 3,
                'phone' => $cek->phone,
                'message' => $cek->msg_tagihan
            ]);
            //ulang notif


            return redirect()->back()->withErrors(['event-not-found' => 'Anda sudah terdaftar., jika ada kendala silahkan hub admin di 6289514010645']);
        }
        $nominal = $event->harga_produk ?? 0;
        if($event->produk=='tp'){
            if($request->paket=='PLATINUM'){
                $nominal = 9998000;
            }elseif($request->paket=='GOLD'){
                $nominal = 4898000;
            }elseif($request->paket=='SILVER'){
                $nominal = 1250000;
            }else{
                $nominal = 197000;
            }
        }
        $tmp = TransaksiSeminar::where('produk', $event->produk)->where('created_at', '>=', date('Y-m-01') . ' 00:00:00')->max('unix') ?? 0;
        $unix = $tmp + 1;
        $bayar = $nominal + $unix;
        $data = [
            'kode_event' => $request->kode_event,
            'nama' => $request->nama ?? '',
            'sapaan' => $request->sapaan,
            'panggilan' => $request->panggilan ?? '',
            'kota' => $request->kota ?? '',
            'provinsi' => $request->prov ?? '',
            'alamat' => $request->alamat ?? '',
            'email' => $request->email,
            'jkel' => $request->jkel ?? '',
            'tgl_lahir' => "{$request->thn}-{$request->bln}-{$request->tgl}" ?? '',
            'phone' => $request->phone,
            'no_ktp' => $request->no_ktp ?? '',
            'program' => $request->program ?? '',
            'nilai' => $nominal,
            'unix'    => $unix,            
            'bayar' => $bayar,
            'bayar_rp' => number_format($bayar),
            'profesi' => $request->profesi ?? '',
            'list' => $request->list ?? '',
            'paket' => $request->paket ?? '',
            'produk' => $event->produk
        ];


        $trx = TransaksiSeminar::create($data);

        $data['id']  = $trx->id;
        $msg_tagihan = ReplaceArray($data, $event->cw_tagihan);
        // $data['msg_tagihan'] = $msg_tagihan;
        // $data['msg_bayar'] = $msg_bayar; 
        TransaksiSeminar::where('id', $trx->id)->update([
            "msg_tagihan" => $msg_tagihan
        ]);


        // $pesan = "Pagi [sapaan] [panggilan] anda baru saja mendaftar dan segera bayar [bayar]";
        $resWA = Whatsapp::send([
            'token' => $event->device_id ?? 3,
            'phone' => $request->phone,
            'message' => $msg_tagihan
        ]);
        $resWA = Whatsapp::send([
            'token' => $event->device_id ?? 3,
            'phone' => $event->group_info,
            'message' => $msg_tagihan
        ]);

        return redirect()->back()->with('success', 'Data anda Berhasil disimpan cek whatsapp anda');
    }

    public function download_sertifikat(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();
        if (!$event) {
            abort(403, 'SEMINAR TIDAK DITEMUKAN');
        }
        $phone = $request->phone;
        $phone = preg_replace('/^0/', '62', $phone);
        $peserta = Seminar::where('kode_event', $event->kode_event)->where('phone', $phone)->first();
        if (!$peserta) {
            abort(403, 'DATA TIDAK DITEMUKAN');
        }
        // return $peserta;
        $nama   = trim(strtoupper($peserta->nama));
        $no     = 'NOMOR : MSD-MWO/IV/2022/' . $peserta->id;
        $file   = $peserta->id . '-' . time() . ".jpg";
        $img    = Image::make(public_path('template/sertifikat_maxwin.png'));
        $img->text($no, 950 - (strlen($no) / 2 * 30), 395, function ($font) {
            $font->file(realpath('assets/font/AstroSpace.ttf'));
            $font->size(50);
            $font->color('#f20e0e');
        });

        $img->text($nama, 950 - (strlen($nama) / 2 * 50), 680, function ($font) {
            $font->file(realpath('assets/font/AstroSpace.ttf'));
            $font->size(80);
        });
        // $img->text(
        //     '24 April 2022',
        //     1425,
        //     1240,
        //     function ($font) {
        //         $font->file(realpath('assets/font/Montserratmed.ttf'));
        //         $font->size(50);
        //     }
        // );
        $name   = "sertikat-" . Date('DmY') . ".JPG";
        $img->save(public_path('images/sertifikat-' . $file));
        $file   = "images/sertifikat" . '-' . $file;
        if ($request->download) {
            return response()->download($file, $name);
        }
        return "<img src='$file' width='75%' height='80%'> <br><br> <center> <a href='?phone=" . $peserta->phone . "&download=Y'><button>Download</button></a></center>";
    }

    public function jointl($domain, $id)
    {
        $bayar = TransaksiSeminar::where('id', $id)->first();
        if ($bayar) {
            if ($bayar->lunas) {
                if ($bayar->status_join == 0) {
                    $tl = "https://t.me/+QGo9Fhpsn3c5MmE1";
                    $bayar->status_join = 1;
                    $bayar->save();
                    return redirect($tl);
                } else {
                    echo "LINK SUDAH TIDAK BERLAKU, LINK BERLAKU HANYA 1X ATAS NAMA , HUB <a href='https://wa.me/6289514010645?text=saya+tidak+bisa+join+ke+group+telegram,+Mohon+dibantu'>WA ADMIN 6289514010645</a>";
                }
            } else {
                echo "TRNSAKSI BELUM DILUNASI, SEGERA TRANSFER KE <BR>";
                echo "Nama : Yayasan Maxmillian Winardi <br>";
                echo "Nomor rek : 141 001 815 4708 <br>";
                echo "DENGAN NILAI Rp. : <i style='color:red'>Rp. " . number_format($bayar->bayar) . "</i>";
            }
        } else {
            echo "LINK TIDAK BERLAKU, LINK BERLAKU HANYA 1X UNTUK YANG SUDAH BAYAR , HUB <a href='https://wa.me/6289514010645?text=saya+tidak+bisa+join+ke+group+telegram,+Mohon+dibantu'>WA ADMIN 6289514010645</a>";
        }
    }

    public function daftar_ulang(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();
        $provinsi = Provinsi::orderBy('name')->get();
        $kota  = Kabupaten::orderBy('name')->get();

        $list = ListPolling::group('maxwin')->get();

        return view('DaftarEvent.ulang', [
            'provinsi' => $provinsi,
            'event' => $event,
            'kota' => $kota,
            'list' => $list
        ]);
    }

    public function testing(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();
        if ($request->ref) {
            Cookie::queue('kode_ref', $request->ref, 1 * 60 * 24 * 30);
        }
        if (!$event) {
            return abort(404, 'Halaman tidak ditemukan');
        }
        if ($event->close_register <= Carbon::now()) {
            $event2   = Event::where('brand', $event->brand)->orderBy('id', 'desc')->first();
            // return $event;
            if ($event2) {
                if ($event2->close_register <= Carbon::now()) {
                    return abort(403, 'REGISTRASI DITUTUP');
                }
                return redirect("https://" . $event2->sub_domain . ".seminar.co.id/?ref=" . $request->ref);
            }
            return abort(403, 'REGISTRASI DITUTUP');
        }
        $ref = $request->ref ?? request()->cookie('kode_ref') ?? '';
        $pengndang = User::where('phone', $ref)->orWhere('kode_ref', $ref)->whereNotNull('kode_ref')->first();
        if (!$pengndang) {
            $ref = preg_replace('/^0/', '62', $ref);
            $pengndang = Seminar::where('phone', $ref)->first();
        }
        $pengundang_nama = $pengndang->nama ?? '';
        $buka_pendaftaran = 1;
        $link = "https://api.whatsapp.com/send/?phone=6287711993838&text=Saya+butuh+bantuan,+pendaftaran+di+" . url('/') . " %0A%0ABerikut ini data saya: %0ANama: %0AEmail: %0ANo hp: %0ATgl lahir: %0AKota/kab:";
        return view('DaftarEvent.templates.dev_property_4-0', compact('pengundang_nama', 'buka_pendaftaran', 'event', 'link'));
    }


    public function joinzoom(Request $request, $subdomain, $kode_event, $phone)
    {
        // $event = Event::where('sub_domain', $subdomain)->whereNotNull('link_zoom')->first();
        $seminar = Seminar::where('kode_event', $kode_event)->where('phone', $phone)->orderBy('id', 'DESC')->first();
        $event = $seminar->event;
        if (($event->sub_domain != $subdomain) || (is_null($event->meeting_id) && is_null($event->link_zoom))) {
            return abort(404);
        }
        $tglEvent = $seminar->tgl_seminar->subMinutes(20);
        $isBeginZoom = $tglEvent->lt(Carbon::now()) ? false : true;

        return view('DaftarEvent.joinzoom', compact('seminar', 'event', 'isBeginZoom'));
    }

    public function rangking(Request $request)
    {
        $domain = request()->getHttpHost();
        $event   = Event::where('sub_domain', explode('.', $domain)[0])->first();
        if (!$event) {
            return abort(404);
        }
        // $data = DB::select("select ref,count(*) j from seminars where kode_event = '" . $event->kode_event . "' group by ref");        
        $data = Seminar::selectRaw('ref,count(phone) as j')->where('kode_event', $event->kode_event)->groupBy('ref')->orderBy('j','desc')->take(10)->get();
        $j    = Seminar::where('kode_event', $event->kode_event)->count();
        return view('DaftarEvent.rangking', compact('data', 'event','j'));
    }
    
}
