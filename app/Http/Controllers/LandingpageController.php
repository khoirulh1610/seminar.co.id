<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Notif;

class LandingpageController extends Controller
{
    public function index(Request $request)
    {
        return view('landingpage');
    }
}
