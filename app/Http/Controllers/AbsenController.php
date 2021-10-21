<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;

class AbsenController extends Controller
{
    public function index(Request $request,$kode_event)
    {
        $title  = "Data Absen Seminar";
        $absen  = Seminar::whereNotNull('absen_at')->where('kode_event',$kode_event)->get();
        return view('absen.absen',compact('absen','title'));
    }
    
}
