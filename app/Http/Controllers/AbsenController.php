<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function index(Request $request, $kode_event)
    {
        $title  = "Data Absen Seminar";
        $absen  = DB::select("select b.*,a.created_at masuk from absensis a left join seminars b on a.seminar_id=b.id where a.kode_event='$kode_event'");
        // return $absen;
        return view('absen.absen', compact('absen', 'title'));
    }
}
