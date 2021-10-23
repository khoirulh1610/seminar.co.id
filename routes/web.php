<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@index')->name('login');
Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@index')->name('register');
Route::post('/register', 'Auth\RegisterController@save')->name('register.save');

Route::get('/lp', function () {    
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () { 

    // Route::get('/','DashboardController@index')->name('dashboard.1');
    Route::get('/dashboard','DashboardController@index')->name('dashboard');
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/user/delete/{id}','UserController@hapus')->name('user.delete');

    Route::get('/peserta/{kode_event}','PesertaController@index')->name('peserta');
    Route::post('/peserta/approve','PesertaController@approve')->name('peserta.approve');
    Route::post('/peserta/importkeuser','PesertaController@importkeuser')->name('peserta.importkeuser');
    Route::get('/peserta/delete/{id}','PesertaController@remove')->name('peserta.delete');
    Route::get('/seminar/rangking/{kode_event}','PesertaController@rangking')->name('peserta.rangking');

    Route::get('/absen/{kode_event}','AbsenController@index')->name('absen');

    Route::get('/setting','SettingController@index')->name('absen');
    Route::get('/setting/baru','SettingController@baru')->name('setting.babru');
    Route::get('/setting/save','SettingController@save')->name('setting.baru');

    Route::get('/event','EventController@index')->name('event');
    Route::get('/event/baru','EventController@baru')->name('event.baru');
    Route::post('/event/save','EventController@save')->name('event.save');
    Route::get('/event/edit/{id}','EventController@edit')->name('event.edit');
    Route::get('event/hapus/{id}','EventController@hapus')->name('event.hapus');


    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('profile/edit','ProfileController@edit')->name('profile.edit');
    Route::post('profile/save','ProfileController@save')->name('profile.save');
    Route::get('/profile/edit/{id}','ProfileController@edit')->name('profile.edit');

    Route::get('/kirimpesan','KirimpesanController@index')->name('kirimpesan');
    Route::get('/kirimpesan/baru','KirimpesanController@create')->name('kirimpesan.baru');
    Route::post('/kirimpesan/save','KirimpesanController@save')->name('kirimpesan.save');
    Route::get('/kirimpesan/preview','KirimpesanController@preview')->name('kirimpesan.preview');
    Route::get('/kirimpesan/process','KirimpesanController@process')->name('kirimpesan.process');

    Route::get('/device/device','DeviceController@device')->name('DeviceController.device');
    Route::get('/device/show','DeviceController@show')->name('DeviceController.show');
    Route::get('/device/start','DeviceController@start')->name('DeviceController.device');
    Route::get('/device/scanqr','DeviceController@qrcode')->name('DeviceController.qrcode');
    Route::get('/device/test','DeviceController@test')->name('DeviceController.test');
    Route::get('/device/delete','DeviceController@delete')->name('device.delete');
    Route::post('/device/save','DeviceController@baru')->name('device.save');
    

    Route::get('/eventbaru', function(){
        return view('event.eventbaru');
    });
    
    Route::any('/logut',function(){
        \Auth::logout();
        return redirect('login');
    });

    Route::get('/mail',function(){
        return view('emails.mailprivew');
    });

    Route::get('/test',function(){
        return DB::table("seminars")->count();
        // $notif = App\Helpers\Notifikasi::send(["device_key"=>"8niD7OgjZ737XWh","phone"=>"085232843165","message"=>"test & test","engine"=>"quods","delay"=>1]);
        // return $notif;
    });
    
    Route::get('/new/{id}',function($id){
        $notif = App\Helpers\Whatsapp::start(["instance"=>(String)$id]);
        return $notif;
    });
    
    Route::get('/qrcode11/{id}',function($id){
        $notif = App\Helpers\Whatsapp::new(["instance"=>(String)$id]);
        return $notif;
    });

    Route::get('/logout/{id}',function($id){
        $db = App\Models\Device::where('id',$id)->update(["status"=>"Start","phone"=>null,"profile_url"=>null,"nama"=>null]);
        $notif = App\Helpers\Whatsapp::logout(["instance"=>(String)$id]);        
        return $notif;
    });

    Route::get('/reset/{id}',function($id){
        $db = App\Models\Device::where('id',$id)->update(["status"=>"Start","phone"=>null,"profile_url"=>null,"nama"=>null]);
        $notif = App\Helpers\Whatsapp::reset(["instance"=>(String)$id]);
        return $notif;
    });
    
    Route::get('/send/{id}',function($id){
        $req = \Request();
        $notif = App\Helpers\Whatsapp::send(["instance"=>(String)$id,"number"=>$req->phone ?? "085232843165","message"=>"Test server whatsapp from https://seminar.co.id"]);
        return $notif;
    });
    
});

