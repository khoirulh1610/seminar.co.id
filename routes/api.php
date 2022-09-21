<?php

use App\Helpers\Whatsapp;
use App\Models\Device;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('testing', 'TestController@index');
Route::any('test', 'TestController@test');

Route::get('/event', 'ApiseminarController@index');
Route::post('/register', 'ApiseminarController@register');
Route::any('/absen', 'ApiseminarController@absen');
Route::any('/absen-save', 'ApiseminarController@absen_save');

Route::get('/provinsi', 'ApiseminarController@provinsi');
Route::get('/kabupaten', 'ApiseminarController@kabupaten');

Route::any('antrian', 'Api\AntrianController@antrian');
Route::any('device', 'Api\AntrianController@device');
Route::any('callback', 'Api\AntrianController@callback');

Route::any('zoom-webhook', 'Api\ZoomController@index');

Route::get('/test', function () {
    $event = Event::where('sub_domain', 'madiun')->orderBy('id', 'desc')->first();
    if ($event) {
        return  Whatsapp::send(["token" => $event->device_id, "phone" => "085232843165", "message" => "test"]);
    }
});

Route::any('kirimin/{phone}/{pesan}', 'ApimaxwinController@kirim');
Route::any('updatin/{phone}/{kode_agen}', 'ApimaxwinController@kode_agen');
Route::any('sender', 'ApimaxwinController@sender');

Route::any('maxwin/seminar/{phone}', 'ApimaxwinController@seminar');
Route::any('maxwin/absen/{phone}', 'ApimaxwinController@absen');
Route::any('maxwin/tidakabsen/{phone}', 'ApimaxwinController@tidakabsen');

Route::any('maxwin/ceklink/{phone}', 'ApimaxwinController@ceklink');

Route::prefix('/seminar')->middleware('seminarkey')->group(function () {
    Route::get('/referal', 'Api\SeminarController@refferal');
    Route::get('/referal/{phone_user}', 'Api\SeminarController@refferal');
    Route::get('/import/{brand}', 'Api\SeminarController@import');
});

Route::any('wa/iswa/{phone}', function ($phone) {
    $device_admin_checker = Device::whereIn('id', [3, 7])->where('status', 'AUTHENTICATED')->first();
    if ($device_admin_checker) {
        $phone      = preg_replace('/^0/', '62', $phone);
        $phone      = preg_replace('/\D/', '', $phone);
        $data = [
            'token' => "{$device_admin_checker->id}",
            'phone' => $phone,
        ];
        return Whatsapp::isWA($data);
    }
    return [
        'status' => 'error',
        'message' => 'Device tidak ada yang AUTHENTICATED'
    ];
});
