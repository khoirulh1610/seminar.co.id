<?php

namespace App\Http\Controllers;

use App\Helpers\Whatsapp;
use App\Models\Event;
use App\Models\Produk;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\TransaksiSeminar;
use App\Models\User;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use Yajra\DataTables\Facades\DataTables;
use App\Models\transaksi_lfw;
use App\Models\lfw;

class LaporanController extends Controller
{
    public function semuaPeserta(Request $request)
    {
        $peserta    = Event::with('seminar')->where('jenis_seminar', 'offline')->get();
        $event      = Event::with('seminar')->get();
        return view('laporan.semuaPeserta', compact('peserta', 'event'));
    }

    public function exportSemua(Request $request)
    {
        // $data    = DB::select("select b.event_title,a.tgl_seminar,b.lokasi,a.sapaan,a.nama,a.panggilan,a.phone,a.email,a.profesi,a.provinsi,a.kota,concat(a.b_tanggal,'/',a.b_bulan,'/',a.b_tahun)tgl_lahir,a.status,a.created_at from seminars a left JOIN `events` b on a.kode_event=b.kode_event");
        if($request->kode_event == 'all'){
            $event      = Event::with('seminar')->get();
            $data       = [];
            foreach ($event as $key) {
                $pengundang         = User::where('phone', $key->ref)->first();
                $data[]     = [
                    'Kode Event'            => $key->kode_event,
                    'Nama Seminar'          => $key->event->event_title ?? '',
                    'Lokasi'                => $key->event->lokasi ?? '',
                    'Tema Seminar'          => $key->event->tema ?? '',
                    'Tipe Seminar'          => $key->event->type ?? '',
                    'Harga Seminar'         => $key->event->harga ?? '',
                    'Narasumber Seminar'    => $key->event->narasumber ?? '',
                    'Tanggal Seminar'       => $key->tgl_seminar,
                    'Nama Lengkap'          => $key->nama,
                    'Nama Panggilan'        => $key->panggilan,
                    'Sapaan'                => $key->sapaan ?? '',
                    'Nomor Handphone'       => $key->phone,
                    'Email'                 => $key->email,
                    'Tanggal Lahir'         => $key->b_tahun . '-' . $key->b_bulan . '-' . $key->b_tanggal,
                    'Profesi'               => $key->profesi,
                    'Referral'              => $key->ref,
                    'Kota'                  => $key->kota,
                    'Provinsi'              => $key->provinsi,
                    'Nama Pengundang'       => $pengundang->nama ?? '',
                    'Sapaan Pengundang'     => $pengundang->sapaan ?? '',
                    'Panggilan Pengundang'  => $pengundang->panggilan ?? '',
                    'Nomor Pengundang'      => $pengundang->phone ?? '',
                ];
            }
        }else{
            $event      = Event::with('seminar')->where('kode_event', $request->kode_event)->get();
            $data       = [];
            foreach ($event as $item) {
                foreach ($item->seminar as $key) {
                    $pengundang         = User::where('phone', $key->ref)->first();
                    $data[]     = [
                        'Kode Event'            => $key->kode_event,
                        'Nama Seminar'          => $key->event->event_title ?? '',
                        'Lokasi'                => $key->event->lokasi ?? '',
                        'Tema Seminar'          => $key->event->tema ?? '',
                        'Tipe Seminar'          => $key->event->type ?? '',
                        'Harga Seminar'         => $key->event->harga ?? '',
                        'Narasumber Seminar'    => $key->event->narasumber ?? '',
                        'Tanggal Seminar'       => $key->tgl_seminar,
                        'Nama Lengkap'          => $key->nama,
                        'Nama Panggilan'        => $key->panggilan,
                        'Sapaan'                => $key->sapaan ?? '',
                        'Nomor Handphone'       => $key->phone,
                        'Email'                 => $key->email,
                        'Tanggal Lahir'         => $key->b_tahun . '-' . $key->b_bulan . '-' . $key->b_tanggal,
                        'Profesi'               => $key->profesi,
                        'Nama Pengundang'       => $pengundang->nama ?? '',
                        'Sapaan Pengundang'     => $pengundang->sapaan ?? '',
                        'Panggilan Pengundang'  => $pengundang->panggilan ?? '',
                        'Nomor Pengundang'      => $pengundang->phone ?? '',
                        'Kota'                  => $key->kota,
                        'Provinsi'              => $key->provinsi,
                    ];
                }
            }
        }
        return (new FastExcel($data))->download('Data_Peserta_Seminar.xlsx');
    }

    public function pesertaOffline(Request $request)
    {
        $event    = Event::with('seminar')->where('jenis_seminar', 'offline')->get();
        return view('laporan.pesertaOffline', compact('event'));
    }

    public function exportOffline(Request $request)
    {
        if($request->kode_event == 'all'){
            $event      = Event::with('seminar')->where('jenis_seminar', 'offline')->get();
            $data       = [];
            foreach ($event as $item) {
                foreach ($item->seminar as $key) {
                    $pengundang         = User::where('phone', $key->ref)->first();
                    if ($key != null) {
                        $data[]     = [
                            'Kode Event'            => $key->kode_event,
                            'Nama Seminar'          => $key->event->event_title ?? '',
                            'Lokasi'                => $key->event->lokasi ?? '',
                            'Tema Seminar'          => $key->event->tema ?? '',
                            'Tipe Seminar'          => $key->event->type ?? '',
                            'Harga Seminar'         => $key->event->harga ?? '',
                            'Narasumber Seminar'    => $key->event->narasumber ?? '',
                            'Tanggal Seminar'       => $key->tgl_seminar,
                            'Nama Lengkap'          => $key->nama,
                            'Nama Panggilan'        => $key->panggilan,
                            'Nomor Handphone'       => $key->phone,
                            'Email'                 => $key->email,
                            'Tanggal Lahir'         => $key->b_tahun . '-' . $key->b_bulan . '-' . $key->b_tanggal,
                            'Profesi'               => $key->profesi,
                            'Sapaan Pengundang'     => $pengundang->sapaan,
                            'Panggilan Pengundang'  => $pengundang->panggilan,
                            'Nama Pengundang'       => $pengundang->nama,
                            'Nomor Pengundang'      => $pengundang->phone,
                            'Kota'                  => $key->kota,
                            'Provinsi'              => $key->provinsi
                        ];
                    }
                }
            }            
        }else{
            $event      = Event::with('seminar')->where('jenis_seminar', 'offline')->where('kode_event', $request->kode_event)->get();
            $data       = [];
            foreach ($event as $item) {
                foreach ($item->seminar as $key) {
                    $pengundang         = User::where('phone', $key->ref)->first();
                    if ($key != null) {
                        $data[]     = [
                            'Kode Event'            => $key->kode_event,
                            'Nama Seminar'          => $key->event->event_title ?? '',
                            'Lokasi'                => $key->event->lokasi ?? '',
                            'Tema Seminar'          => $key->event->tema ?? '',
                            'Tipe Seminar'          => $key->event->type ?? '',
                            'Harga Seminar'         => $key->event->harga ?? '',
                            'Narasumber Seminar'    => $key->event->narasumber ?? '',
                            'Tanggal Seminar'       => $key->tgl_seminar,
                            'Nama Lengkap'          => $key->nama,
                            'Nama Panggilan'        => $key->panggilan,
                            'Nomor Handphone'       => $key->phone,
                            'Email'                 => $key->email,
                            'Tanggal Lahir'         => $key->b_tahun . '-' . $key->b_bulan . '-' . $key->b_tanggal,
                            'Profesi'               => $key->profesi,
                            'Sapaan Pengundang'     => $pengundang->sapaan,
                            'Panggilan Pengundang'  => $pengundang->panggilan,
                            'Nama Pengundang'       => $pengundang->nama,
                            'Nomor Pengundang'      => $pengundang->phone,
                            'Kota'                  => $key->kota,
                            'Provinsi'              => $key->provinsi
                        ];
                    }
                }
            }    
        }

        $header_style = (new StyleBuilder())->setFontBold()->build();
        return (new FastExcel($data))->headerStyle($header_style)->download('Data_Peserta_Seminar.xlsx');
    }

    public function pesertaOnline(Request $request)
    {
        $event    = Event::with('seminar')->where('jenis_seminar', 'online')->get();
        return view('laporan.pesertaOnline', compact('event'));
    }

    public function exportOnline(Request $request)
    {
        if($request->kode_event == 'all'){
            $event      = Event::with('seminar')->where('jenis_seminar', 'online')->get();
            $data       = [];
            foreach ($event as $item) {
                foreach ($item->seminar as $key) {
                    $pengundang         = User::where('phone', $key->ref)->first();
                    if ($key != null) {
                        $data[]     = [
                            'Kode Event'            => $key->kode_event,
                            'Nama Seminar'          => $key->event->event_title ?? '',
                            'Lokasi'                => $key->event->lokasi ?? '',
                            'Tema Seminar'          => $key->event->tema ?? '',
                            'Tipe Seminar'          => $key->event->type ?? '',
                            'Harga Seminar'         => $key->event->harga ?? '',
                            'Narasumber Seminar'    => $key->event->narasumber ?? '',
                            'Tanggal Seminar'       => $key->tgl_seminar,
                            'Nama Lengkap'          => $key->nama,
                            'Nama Panggilan'        => $key->panggilan,
                            'Nomor Handphone'       => $key->phone,
                            'Email'                 => $key->email,
                            'Tanggal Lahir'         => $key->b_tahun . '-' . $key->b_bulan . '-' . $key->b_tanggal,
                            'Sapaan Pengundang'     => $pengundang->sapaan,
                            'Panggilan Pengundang'  => $pengundang->panggilan,
                            'Nama Pengundang'       => $pengundang->nama,
                            'Nomor Pengundang'      => $pengundang->phone,
                            'Profesi'               => $key->profesi,
                            'Kota'                  => $key->kota,
                            'Provinsi'              => $key->provinsi
                        ];
                    }
                }
            }
        }else{
            $event      = Event::with('seminar')->where('jenis_seminar', 'online')->where('kode_event', $request->kode_event)->get();
            $data       = [];
            foreach ($event as $item) {
                foreach ($item->seminar as $key) {
                    $pengundang         = User::where('phone', $key->ref)->first();
                    if ($key != null) {
                        $data[]     = [
                            'Kode Event'            => $key->kode_event,
                            'Nama Seminar'          => $key->event->event_title ?? '',
                            'Lokasi'                => $key->event->lokasi ?? '',
                            'Tema Seminar'          => $key->event->tema ?? '',
                            'Tipe Seminar'          => $key->event->type ?? '',
                            'Harga Seminar'         => $key->event->harga ?? '',
                            'Narasumber Seminar'    => $key->event->narasumber ?? '',
                            'Tanggal Seminar'       => $key->tgl_seminar,
                            'Nama Lengkap'          => $key->nama,
                            'Nama Panggilan'        => $key->panggilan,
                            'Nomor Handphone'       => $key->phone,
                            'Email'                 => $key->email,
                            'Tanggal Lahir'         => $key->b_tahun . '-' . $key->b_bulan . '-' . $key->b_tanggal,
                            'Profesi'               => $key->profesi,
                            'Sapaan Pengundang'     => $pengundang->sapaan,
                            'Panggilan Pengundang'  => $pengundang->panggilan,
                            'Nama Pengundang'       => $pengundang->nama,
                            'Nomor Pengundang'      => $pengundang->phone,
                            'Kota'                  => $key->kota,
                            'Provinsi'              => $key->provinsi
                        ];
                    }
                }
            }
        }

        return (new FastExcel($data))->download('Data_Peserta_Seminar.xlsx');
    }


    public function daftarEvent(Request $request, Event $event)
    {
        if ($request->ajax()) {
            $data = TransaksiSeminar::with('user')->where('produk', 'maxwin')->whereNull('duplicat');
            if ($request->lunas == 'sudah') {
                $data->whereNotNull('lunas');
            } elseif ($request->lunas == 'belum') {
                $data->whereNull('lunas');
            }
            return DataTables::of($data)->tojson();
        }

        return view('laporan.daftarEvent', [
            // 'data' => $data->get(),
            'lunas_filter' => $request->lunas ?? false,
            'event' => $event
        ]);
    }

    public function daftarEvent_lfw(Request $request, Event $event)
    {
        if ($request->ajax()) {
            $data = transaksi_lfw::where('produk', 'lfw')->whereNull('duplicat');
            if ($request->lunas == 'sudah') {
                $data->whereNotNull('lunas');
            } elseif ($request->lunas == 'belum') {
                $data->whereNull('lunas');
            }
            return DataTables::of($data)->tojson();
        }

        return view('laporan.daftarEvent_lfw', [
            // 'data' => $data->get(),
            'lunas_filter' => $request->lunas ?? false,
            'event' => $event
        ]);
    }

    public function exportevent(Request $request)
    {
        $event      = TransaksiSeminar::with('user')->where('produk', 'maxwin')->whereNull('duplicat')->get();
        $data       = [];
        foreach ($event as $key) {
            // dd($item);
            // foreach ($item as $key) {
            if ($key != null) {
                $data[]     = [
                    'Kode Event'        => $key->kode_event ?? '',
                    'Nama Seminar'      => $key->produk,
                    'Nama Lengkap'      => $key->nama ?? '',
                    'Sapaan'            => $key->sapaan ?? '',
                    'Nama Panggilan'    => $key->panggilan,
                    'Nomor Handphone'   => $key->phone,
                    'Email'             => $key->email,
                    'Tanggal Lahir'     => $key->tgl_lahir,
                    'Jenis Kelamin'     => $key->jkel,
                    'Tanggal Seminar'   => $key->event->tgl_event,
                    'Kota'              => $key->kota,
                    'Provinsi'          => $key->provinsi,
                    'Alamat'            => $key->alamat,
                    'Profesi'           => $key->profesi,
                    'Harga Seminar'     => $key->nilai,
                    'Harga Bayar'       => $key->bayar_rp,
                    'Tanggal Lunas'     => $key->lunas,
                    'Tanggal Bayar'     => $key->tgl_bayar,
                    'Nama Pengundang'   => $key->user->nama ?? '',
                    'Email Pengundang'  => $key->user->email ?? ''
                ];
            }
            // }
        }
        return (new FastExcel($data))->download('Data_Peserta_Seminar.xlsx');
    }

    public function daftarEventApply(TransaksiSeminar $transaksiSeminar)
    {

        $produk = Produk::where('name', $transaksiSeminar->produk)->first();
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
        $transaksiSeminar->update([
            'msg_bayar' => ReplaceArray($transaksiSeminar, $produk->cw_bayar_lunas),
            'lunas' => Carbon::now(),
            'app_id' => Auth::id()
        ]);

        $resWA = Whatsapp::send([
            'token' => 73,
            'phone' => $transaksiSeminar->phone,
            'message' => $transaksiSeminar->msg_bayar
        ]);
        $resWAG = Whatsapp::send([
            'token' => 73,
            'phone' => '120363042948087196@g.us',
            'message' => '*Pembayaran* diterima dari *' . $transaksiSeminar->nama . '* untuk produk ' . $transaksiSeminar->produk . ' Senilai *Rp. ' . number_format($transaksiSeminar->bayar) . '*' . "\r\n" .'=================='. "\r\n" . "\r\n" . $transaksiSeminar->msg_bayar
        ]);
        Log::info([$resWA, $resWAG]);

        $data             = array(
            'sapaan'         => $transaksiSeminar->sapaan,
            'panggilan'      => $transaksiSeminar->panggilan,
            'nama'           => $transaksiSeminar->nama,
            'phone'          => $transaksiSeminar->phone,
            'email'          => $transaksiSeminar->email,
            'kode_event'     => $transaksiSeminar->kode_event,
            'provinsi'       => $transaksiSeminar->provinsi,
            'kota'           => $transaksiSeminar->kota,
            'profesi'        => $transaksiSeminar->profesi,
            'alamat'         => $transaksiSeminar->alamat,
            'tgl_lahir'      => $transaksiSeminar->tgl_lahir,
            'jkel'           => $transaksiSeminar->jkel,
            'bayar'          => $transaksiSeminar->bayar,
            'unix'           => $transaksiSeminar->unix,
            'bayar_rp'       => $transaksiSeminar->bayar_rp,
        );
        $kir = Whatsapp::kemaxwin($data);

        return redirect()->back();
    }

    public function importMutasi(Request $request)
    {
        $file = $request->file('file-mutasi');
        $fileName = 'afile-mutasi.' . $file->getClientOriginalExtension();
        $path = $file->move('uploads/', $fileName);
        $now = Carbon::now();
        (new FastExcel)->import($path, function ($line) use ($now) {
            $nominal = str_replace([',', '.00'], '', $line["Credit"]);
            $transaksi = TransaksiSeminar::with('produk')->where('bayar', $nominal)->where('lunas', null)->first();
            if ($transaksi) {
                $produk = $transaksi->produk;
                $transaksi->update([
                    'msg_bayar' => ReplaceArray($transaksi, $produk->cw_bayar_lunas),
                    'lunas' => $now,
                    'mutasi_payload' => $line,
                    'app_id' => Auth::id()
                ]);
                $resWA = Whatsapp::send([
                    'token' => 73,
                    'phone' => $transaksi->phone,
                    'message' => $transaksi->msg_bayar
                ]);
                $resWA = Whatsapp::send([
                    'token' => 73,
                    'phone' => '120363042948087196@g.us',
                    'message' => $transaksi->msg_bayar
                ]);
            }
        });

        return redirect()->back();
    }


    public function notifulang($id)
    {
        # code...
        $cek = TransaksiSeminar::where('id', $id)->first();
        $pesan = $cek->msg_tagihan;
        $phone = $cek->phone;
        $resWA = Whatsapp::send([
            'token' => 73,
            'phone' => $phone,
            'message' => $pesan
        ]);
        return redirect()->back();
    }


}


// [
//   "Account No" => "1410018154708"
//   "Date" => "02/04/22"
//   "Val. Date" => "02/04/22"
//   "Transaction Code" => "6636"
//   "Description" => "MONTHLY CARD CHARGE 0004837950002175047  "
//   "Reference No." => ""
//   "Debit" => "5,000.00"
//   "Credit" => ".00"
//   "" => ""
// ]
