<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Seminar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SeminarController extends Controller
{
  public function refferal(Request $request, $phone_user)
  {
    $kode_events = Event::where('produk', 'LFW')->pluck('kode_event')->toArray();
    $user        = Seminar::firstWhere('phone', $phone_user);
    if (!$user) {
      return response()->json([
        'status'  => 'error',
        'phone'   => $phone_user,
        'message' => 'User not found',
      ]);
    }
    $data       = $user->downline()->whereIn('kode_event', $kode_events)->get();
    $referral   = DataTables::of($data, $user)->toJson();
    return $referral;
    // return response()->json([
    //   // 'status'    => 'success',
    //   'user'      => $user,
    //   'refferal'  => $referral    
    // ]);
  }

  public function import(Request $request)
  {
    $kode_events  = Event::where('produk', 'LFW')->pluck('kode_event')->toArray();
    // return $kode_events;
    $data = Seminar::with('event')->whereIn('kode_event', $kode_events)
      ->whereDate('tgl_seminar', '<', Carbon::now())
      ->orderBy('created_at', 'asc')->get();
    return response()->json([
      'status'    => 'success',
      'data'      => $data,
    ]);
  }
}
