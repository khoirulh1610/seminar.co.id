<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notif;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $notif  = Notif::get();
        return view('setting.setting',compact('notif'));
    }

    public function baru(Request $request)
    {
        return view('setting.settingbaru');
    }

    public function save(Request $request)
    {
        $notif              = new Notif();
        $notif->device_key  = $request->device_key;
        $notif->service     = $request->service;
        $notif->save();
    }
}
