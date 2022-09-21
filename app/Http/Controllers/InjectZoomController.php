<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PesertaInject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use DB;

class InjectZoomController extends Controller
{
    public function index(Request $request)
    {
        $peserta        = PesertaInject::get();
        $event          = Event::where('status',1)->orderBy('tgl_event','asc')->where('tgl_event','>=',Date('Y-m-d H:00'))->get();
        $notNullLink    = PesertaInject::where('event_id', $request->event_id)->whereNotNull('link_zoom')->count();
        $gInject        = DB::select("select a.event_id,b.event_title from peserta_injects a left join events b on a.event_id=b.id group by a.event_id");
        // return  $gInject;
        return view('injectzoom.inject', compact('peserta', 'event','gInject'));
    }

    function inject(Request $request)
    {
        $file           = $request->path;
        $data           = (new FastExcel)->import($file);

        foreach ($data as $key) {
            try {
                $data = PesertaInject::insert([
                    'event_id'      => $request->event_id,
                    'sapaan'        => $key['sapaan'],
                    'panggilan'     => $key['panggilan'],
                    'nama'          => $key['nama'],
                    'email'         => $key['email'],
                    'phone'         => $key['phone'],
                    'tgl_lahir'     => $key['tgl_lahir'] ?? null,
                    'kota'          => $key['kota'] ?? null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            } catch (\Throwable $th) {
                Log::emergency("Inject error : ".$th->getMessage());
            }
            
        }
        Artisan::call("inject:peserta");
        return redirect('inject/zoom')->with('success', 'Inject data sedang di proses');
    }

    public function progresInject(Request $request)
    {
        $totalPeserta       = PesertaInject::where('event_id', $request->event_id)->count();
        if ($totalPeserta == 0) {
            return response()->json([
                'status'    => 'error', 
                'message'   => 'Data peserta kosong'
            ]);
        }
        $notNullLink   = PesertaInject::where('event_id', $request->event_id)->whereNotNull('link_zoom')->count();
        // Log::info("{$request->event_id}");
        $persentase = number_format(($notNullLink / $totalPeserta) * 100, 2);
        return [
            'total'         => $totalPeserta,
            'notNull'       => $notNullLink,
            'persentase'    => $persentase,  
            'event_id'      => $request->event_id,
        ];
    }

    public function upload(Request $request)
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFile(UploadedFile $file)
    {

        if ($file) {
            // $file            = $request->file('file');
            $filepath           = 'uploads/';
            $fileName           = 'dataInject_' . time() . "." . $file->getClientOriginalExtension();
            $file->move('uploads/', $fileName);
            $file_path          = $filepath . $fileName;
        }
        $public_path = public_path($file_path);
        // sleep(10);

        return response()->json([
            'status'    => 'uploaded',
            'path'      => $public_path,
            // 'name' => $fileSaved->name,
        ]);
    }

    public function export(Request $request)
    {
        $data   =   PesertaInject::where('event_id', $request->event_id)->get();
        $event  =   Event::where('id', $request->event_id)->first(); 
        // $peserta = [];
        // foreach ($data as $key) {
        //     $peserta[] = [
        //         'Sapaan'        => $key->sapaan,
        //         'Panggilan'     => $key->panggilan,
        //         'Nama'          => $key->nama,
        //         'Email'         => $key->email,
        //         'Phone'         => $key->phone,
        //         'Tgl lahir'     => $key->tgl_lahir,
        //         'Kota'          => $key->kota,
        //         'Link zoom'     => $key->link_zoom,
        //     ];
        //     $event  =   Event::where('id', $request->event_id)->first();            
        // }
        return (new FastExcel($data))->download('Data_Inject_'.$event->event_title.'.xlsx');
    }

    public function delete(Request $request)
    {
        $data = PesertaInject::where('event_id', $request->event_id)->delete();
        return redirect('inject/zoom')->with('success', 'Data berhasil di hapus');
    }   
}
