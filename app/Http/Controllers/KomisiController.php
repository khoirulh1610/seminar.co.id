<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash, DB;

class KomisiController extends Controller
{
    //
    public function cek()
    {
        # code...
        $komisi = DB::table('peserta_komisis')->where('id','>=',489)->get();
        return view('komisi.index', compact('komisi'));
    }
}
