<?php

use App\Helpers\Whatsapp;
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

Route::get('/event','ApiseminarController@index');
Route::post('/register','ApiseminarController@register');
Route::any('/absen','ApiseminarController@absen');
Route::any('/absen-save','ApiseminarController@absen_save');

Route::get('/provinsi','ApiseminarController@provinsi');
Route::get('/kabupaten','ApiseminarController@kabupaten');

Route::any('antrian','Api\AntrianController@antrian');
Route::any('device','Api\AntrianController@device');
Route::any('callback','Api\AntrianController@callback');

Route::any('zoom-webhook','Api\ZoomController@index');

Route::get('/test',function(){
    $event = Event::where('sub_domain','madiun')->orderBy('id','desc')->first();
    if($event){
        return  Whatsapp::send(["token"=>$event->device_id,"phone"=>"085232843165","message"=>"test"]);
    }
});