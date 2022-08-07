<?php

namespace App\Http\Controllers;

use App\Helpers\Whatsapp;
use App\Models\Antrian;
use App\Models\Device;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class WaBtnController extends Controller
{
    public function index(Request $request)
    {
        $row            = $request->row ?? 10;
        $kirimpesan     = Antrian::where('user_id', Auth::id())->where('type_message', 'Button')->orderBy('id', 'desc')->paginate($row);
        $status_pesan   = Antrian::where('user_id', Auth::id())->where('type_message', 'Button')->groupBy('report')->pluck('report');
        return view('wabutton.kirimpesan', compact('kirimpesan', 'status_pesan'));
    }

    public function preview(Request $request)
    {
        $preview    = Antrian::where('user_id', Auth::id())->where('type_message', 'Button')->where('status', '<=', 1)->simplePaginate(6);
        $title      = "Preview Pesan";
        return view('wabutton.preview', compact('preview', 'title'));
    }

    public function process(Request $request)
    {
        $update                     = Antrian::where('user_id', Auth::user()->id)->where('type_message', 'Button')->where('status', 0)->update(["status" => 1]);
        $data                       = Antrian::selectRaw('device_id')->where('user_id', Auth::id())->where('type_message', 'Button')->where('status', 1)->groupBy('device_id')->take(3000)->get();
        $pesan = [];
        foreach ($data as $row) {
            $all                    = Antrian::where('type_message', 'Button')->where('user_id', Auth::id())->where('status', 1)->where('device_id', $row->device_id)->get();
            $p = [];
            foreach ($all as $rr) {
                $v =  [
                    "phone"     => $rr->phone,
                    "message"   => $rr->message,
                    "headerType" => 1,
                    "type"      => "Button",
                    "payload"   => []
                ];

                // Log::info('pylod', [$rr]);
                if (!is_null($rr->btn1)) {
                    $v['payload'][] = $this->addPayload($rr->btn1, 'b1');
                }
                if (!is_null($rr->btn2)) {
                    $v['payload'][] = $this->addPayload($rr->btn2,  'b2');
                }
                if (!is_null($rr->btn3)) {
                    $v['payload'][] = $this->addPayload($rr->btn3,  'b3');
                }
                $p[] = $v;
            }
            $pesan = [
                "token"     => $rr->device_id,
                "data"      => $p,
            ];

            $kirim = Whatsapp::queue($pesan);
            Log::info('this is v', $pesan);
            Log::info('this is kirim', [$kirim]);
            //    return $kirim;
        }

        return redirect('/button');
    }

    protected function addPayload($text, $id)
    {
        return (object)[
            'id'      => $id,
            'text'    => $text
        ];
    }

    public function create(Request $request)
    {
        $devices        = Device::where('user_id', Auth::id())->get();
        $log            = DB::table('logkirims')->where('user_id', Auth::user()->id)->where('jenis_proses', 'Button')->orderBy('id', 'desc')->first();
        $event          = Event::orderBy('tgl_event', 'DESC')->get();
        return view('wabutton.pesanbaru', compact('devices', 'log', 'event'));
    }

    public function save(Request $request)
    {
        try {
            $lampiran      = null;
            $path_lampiran = null;
            $file_name     = null;
            $type          = "Button";
            if ($request->lampiran) {
                $file = $request->file('lampiran');
                $filepath = 'uploads/';
                $fileName = 'lampiran_' . time() . "." . $file->getClientOriginalExtension();
                $file_name = $file->getClientOriginalName();
                $file->move('uploads/', $fileName);
                $lampiran = url('uploads/' . $fileName);
                $path_lampiran =  'uploads/' . $fileName;
            }

            $l      = DB::table('logkirims')->insert([
                "jenis_proses"  => $type,
                "user_id"       => Auth::user()->id,
                "message1"      => $request->message,
                "device_id"     => $request->device_id,
                "target"        => $request->target,
                "file1"         => $lampiran,
                "a1"            => $request->btn1,
                "a2"            => $request->btn2,
                "a3"            => $request->btn3,
                "b1"            => $request->reply1,
                "b2"            => $request->reply2,
                "b3"            => $request->reply3,
                "created_at"    => Carbon::now()
            ]);

            if ($request->target == "Upload") {
                $file = $request->file('file');
                $filepath = 'uploads/';
                $fileName = 'file_' . time() . "." . $file->getClientOriginalExtension();
                $file->move('uploads/', $fileName);
                $data = (new FastExcel)->import($filepath . $fileName);
                if (file_exists($filepath . $fileName)) {
                    unlink($filepath . $fileName);
                }
                // Proses Data
                foreach ($data as $exl) {
                    if ($exl['phone']) {
                        $message               = ReplaceArray($exl, $request->message);
                        $phone                 = preg_replace('/^0/', '62', $exl['phone']);
                        $phone                 = preg_replace('/\D/', '', $phone);
                        if ($phone) {
                            $antrian               = new Antrian();
                            $antrian->user_id      = Auth::id();
                            $antrian->device_id    = $request->device_id;
                            $antrian->phone        = $phone;
                            $antrian->message      = $message;
                            $antrian->judul        = $request->judul;
                            $antrian->status       = 0;
                            $antrian->pause        = rand($request->min ?? 0, $request->max ?? 10);
                            $antrian->file         = $lampiran;
                            $antrian->file_name    = $file_name;
                            $antrian->file_path    = $path_lampiran;
                            $antrian->btn1         = $request->btn1;
                            $antrian->btn2         = $request->btn2;
                            $antrian->btn3         = $request->btn3;
                            $antrian->reply1       = $request->reply1;
                            $antrian->reply2       = $request->reply2;
                            $antrian->reply3       = $request->reply3;
                            $antrian->save();
                        }
                    }
                }
            } else if ($request->target == "Manual") {
                $data = explode(",", $request->data_target);
                if (count($data)) {
                    // Proses Data
                    for ($i = 0; $i < count($data); $i++) {
                        $phone               = preg_replace('/^0/', '62', $data[$i]);
                        if ($phone) {
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = $request->message;
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0, $request->max ?? 10);
                            $antrian->file          = $lampiran;
                            $antrian->file_name     = $file_name;
                            $antrian->file_path     = $path_lampiran;
                            $antrian->judul         = $request->judul;
                            $antrian->type_message  = $type;
                            $antrian->btn1          = $request->btn1;
                            $antrian->btn2          = $request->btn2;
                            $antrian->btn3          = $request->btn3;
                            $antrian->reply1        = $request->reply1;
                            $antrian->reply2        = $request->reply2;
                            $antrian->reply3        = $request->reply3;
                            $antrian->save();
                        }
                    }
                }
            } else if ($request->target == "Seminar") {
                if ($request->target_kirim == "Semua Peserta") {
                    $peserta    = DB::select("select * from seminars where kode_event like '%" . $request->kode_event . "%'");
                    foreach ($peserta as $key => $value) {
                        $phone               = preg_replace('/^0/', '62', $value->phone);
                        if ($phone) {
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = $request->message;
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0, $request->max ?? 10);
                            $antrian->file          = $lampiran;
                            $antrian->file_name     = $file_name;
                            $antrian->file_path     = $path_lampiran;
                            $antrian->judul         = $request->judul;
                            $antrian->type_message  = $type;
                            $antrian->btn1          = $request->btn1;
                            $antrian->btn2          = $request->btn2;
                            $antrian->btn3          = $request->btn3;
                            $antrian->reply1        = $request->reply1;
                            $antrian->reply2        = $request->reply2;
                            $antrian->reply3        = $request->reply3;
                            $antrian->save();
                        }
                    }
                } else if ($request->target_kirim == "Sudah Absen") {
                    $peserta    = DB::select("select * from seminars where id in (select seminar_id from absensis where kode_event like '%" . $request->kode_event . "%')");
                    foreach ($peserta as $value) {
                        $phone               = preg_replace('/^0/', '62', $value->phone);
                        if ($phone) {
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = $request->message;
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0, $request->max ?? 10);
                            $antrian->file          = $lampiran;
                            $antrian->file_name     = $file_name;
                            $antrian->file_path     = $path_lampiran;
                            $antrian->judul         = $request->judul;
                            $antrian->type_message  = $type;
                            $antrian->btn1          = $request->btn1;
                            $antrian->btn2          = $request->btn2;
                            $antrian->btn3          = $request->btn3;
                            $antrian->reply1        = $request->reply1;
                            $antrian->reply2        = $request->reply2;
                            $antrian->reply3        = $request->reply3;
                            $antrian->save();
                        }
                    }
                } else if ($request->target_kirim == "Belum Absen") {
                    $peserta    = DB::select("select * from seminars where id not in (select seminar_id from absensis where kode_event like '%" . $request->kode_event . "%') and kode_event like '%" . $request->kode_event . "%'");
                    foreach ($peserta as $value) {
                        $phone               = preg_replace('/^0/', '62', $value->phone);
                        if ($phone) {
                            $antrian                = new Antrian();
                            $antrian->user_id       = Auth::id();
                            $antrian->device_id     = $request->device_id;
                            $antrian->phone         = $phone;
                            $antrian->message       = $request->message;
                            $antrian->status        = 0;
                            $antrian->pause         = rand($request->min ?? 0, $request->max ?? 10);
                            $antrian->file          = $lampiran;
                            $antrian->file_name     = $file_name;
                            $antrian->file_path     = $path_lampiran;
                            $antrian->judul         = $request->judul;
                            $antrian->type_message  = $type;
                            $antrian->btn1          = $request->btn1;
                            $antrian->btn2          = $request->btn2;
                            $antrian->btn3          = $request->btn3;
                            $antrian->reply1        = $request->reply1;
                            $antrian->reply2        = $request->reply2;
                            $antrian->reply3        = $request->reply3;
                            $antrian->save();
                        }
                    }
                }
            }
            return redirect('/button/preview');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function send(Request $request)
    {
        $antrian = Antrian::where('user_id', Auth::id())->where('type_message', 'Button')->where('id', $request->id)->first();
        Log::info('this is data', $antrian);
        if ($antrian) {
            $data = [
                "token"     => $antrian->device_id,
                "phone"     => $antrian->phone,
                "message"   => $antrian->message,
                "file_url"  => $antrian->file,
                "file_name" => $antrian->file_name,

            ];

            Log::info('this is data', $data);

            $notif = Whatsapp::send($data);
            $r = json_decode($notif);
            if ($r) {
                if ($r->message == 'Terkirim') {
                    $antrian->status = 2;
                    $antrian->messageid = $r->data->messageid ?? '';
                    $antrian->report = $r->data->message ?? '';
                    $antrian->save();
                } else {
                    $antrian->status = 2;
                    $antrian->report = $r->data->message ?? '';
                    $antrian->save();
                }
            }
            return $notif;
        } else {
            return ["status" => false, "message" => "Data not found"];
        }
    }

    public function remove(Request $request)
    {

        if ($request->status == "semua") {
            $antrian = Antrian::where("user_id", Auth::id())->where('type_message', 'Button');
        } else {
            $antrian = Antrian::where("user_id", Auth::id())->where('type_message', 'Button')->where('status', $request->status);
            if ($request->id) {
                $antrian = Antrian::where("user_id", Auth::id())->where('type_messsage', 'Button')->where('id', $request->id);
            }
        }
        if ($antrian) {
            $antrian->delete();
        }
        return redirect('/button');
    }

    public function batal(Request $request)
    {
        $remove     = Antrian::where('user_id', Auth::id())->where('type_message', 'Button')->where('status', 0)->delete();
        return redirect('/button');
    }
}
