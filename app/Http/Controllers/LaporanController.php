<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Seminar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function semuaPeserta(Request $request)
    {
        $peserta    = Seminar::all();
        return view('laporan.semuaPeserta', compact('peserta'));
    }

    public function exportSemua(Request $request)
    {
        # code...
    }

    public function pesertaOffline(Request $request)
    {
        $event    = Event::with('seminar')->where('jenis_seminar', 'offline')->get();
        return view('laporan.pesertaOffline', compact('event'));
    }

    public function exportOffline(Request $request)
    {
        # code...
    }

    public function pesertaOnline(Request $request)
    {
        $event    = Event::where('jenis_seminar', 'online')->get();
        return view('laporan.pesertaOnline', compact('event'));
    }

    public function exportOnline(Request $request)
    {
        # code...
    }
}
