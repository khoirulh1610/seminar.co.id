<?php

use App\Helpers\HelperZoom;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebNotificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

// Route::get('/provinsi', 'DaftarEventController@provinsi');    


Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login24');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Auth\RegisterController@index')->name('register');
Route::post('/register', 'Auth\RegisterController@save')->name('register.save');
Route::get('/event/{event:kode_event}/tiket/{phone}', 'EventController@tiket')->name('event.tiket');
Route::get('/event/tiket/{phone}', 'EventController@tiketall')->name('event.tiketall');
Route::get('/event/{event:kode_event}/tiket2/{phone}', 'EventController@tiket2')->name('event.tiket2');
Route::get('/lp', function () {
    return view('welcome');
});
Route::get('landingpage', 'LandingpageController@index')->name('landingpage');
Route::get('/kabupaten', 'DaftarEventController@kabupaten');  


Route::group(array('domain' => '{subdomain}.seminar.co.id'), function($subdomain) {
    if($subdomain){
        Route::get('/', 'DaftarEventController@index');              
        Route::get('/absen', 'DaftarEventController@absen');    
        Route::post('/absen-save', 'DaftarEventController@absen_save');
        Route::post('/seminar-register', 'DaftarEventController@register');              
    }else{
        Route::get('/', 'Auth\LoginController@index')->name('login.1');
    }    
});

Route::group(['middleware' => ['auth']], function () {

    // Route::get('/','DashboardController@index')->name('dashboard.1');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/', 'DashboardController@index')->name('dashboard2');
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/user/delete/{id}', 'UserController@hapus')->name('user.delete');

    Route::get('/peserta/{kode_event}', 'PesertaController@index')->name('peserta');
    Route::get('/peserta/export/{kode_event}', 'PesertaController@Export')->name('peserta.export');
    Route::post('/peserta/approve', 'PesertaController@approve')->name('peserta.approve');
    Route::post('/peserta/save', 'PesertaController@save')->name('peserta.save');
    Route::get('/peserta/resend-notif/{id}', 'PesertaController@ResendNotif')->name('peserta.ResendNotif');
    Route::post('/peserta/importkeuser', 'PesertaController@importkeuser')->name('peserta.importkeuser');
    Route::get('/peserta/delete/{id}', 'PesertaController@remove')->name('peserta.delete');
    Route::get('/seminar/rangking/{kode_event}', 'PesertaController@rangking')->name('peserta.rangking');
    Route::get('/seminar/komisi/{kode_event}', 'PesertaController@Komisi')->name('peserta.komisi');

    Route::get('/absen/{kode_event}', 'AbsenController@index')->name('absen');

    Route::get('/setting', 'SettingController@index')->name('absen2');
    Route::get('/setting/baru', 'SettingController@baru')->name('setting.babru');
    Route::get('/setting/save', 'SettingController@save')->name('setting.baru');

    Route::get('/event', 'EventController@index')->name('event');
    Route::get('/event/baru', 'EventController@baru')->name('event.baru');
    Route::post('/event/save', 'EventController@save')->name('event.save');
    Route::get('/event/edit/{id}', 'EventController@edit')->name('event.edit');
    Route::get('event/hapus/{id}', 'EventController@hapus')->name('event.hapus');
    Route::get('sertifikat/{kode_event}', 'EventController@sertifikat')->name('sertifikat');
    Route::get('/sertifikat-download/{id}', 'EventController@download')->name('sertifikat.download');
    Route::get('cw/{kode_event}', 'EventController@cw')->name('cw');

    Route::get('/event/{event:kode_event}/absen', 'EventController@absen')->name('event.absen');
    Route::post('/event/{event:kode_event}/absen', 'EventController@absenAdd');
    Route::get('/event/{event:kode_event}/absensi', 'EventController@pesertaHadir')->name('event.absensi');
    Route::delete('/event/{event:kode_event}/absen/{id}', 'EventController@pesertaDelete');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('profile/save', 'ProfileController@save')->name('profile.save');
    Route::get('/profile/edit/{id}', 'ProfileController@edit')->name('profile.editByID');

    Route::get('/kirimpesan', 'KirimpesanController@index')->name('kirimpesan');
    Route::get('/kirimpesan/baru', 'KirimpesanController@create')->name('kirimpesan.baru');
    Route::post('/kirimpesan/save', 'KirimpesanController@save')->name('kirimpesan.save');
    Route::get('/kirimpesan/preview', 'KirimpesanController@preview')->name('kirimpesan.preview');
    Route::get('/kirimpesan/process', 'KirimpesanController@process')->name('kirimpesan.process');
    Route::get('/kirimpesan/send', 'KirimpesanController@send')->name('kirimpesan.send');
    Route::any('/kirimpesan/remove', 'KirimpesanController@remove')->name('kirimpesan.remove');

    Route::get('/device/device', 'DeviceController@device')->name('DeviceController.device');
    Route::get('/device/show', 'DeviceController@show')->name('DeviceController.show');
    Route::get('/device/start', 'DeviceController@start')->name('DeviceController.device_start');
    Route::get('/device/scanqr', 'DeviceController@qrcode')->name('DeviceController.qrcode');
    Route::get('/device/test', 'DeviceController@test')->name('DeviceController.test');
    Route::get('/device/delete', 'DeviceController@delete')->name('device.delete');
    Route::post('/device/save', 'DeviceController@baru')->name('device.save');
    Route::get('/device/export', 'DeviceController@ExportKontak')->name('device.ExportKontak');
    Route::get('/device/get-group', 'DeviceController@getGroup')->name('device.getGroup');
    Route::get('/device/export-group', 'DeviceController@ExportGroup')->name('device.ExportGroup');
    Route::get('/device/export-allgroup', 'DeviceController@getAllGroup')->name('device.getAllGroup');

    Route::get('/semuaPeserta', 'LaporanController@semuaPeserta');
    Route::get('/pesertaOffline', 'LaporanController@pesertaOffline');
    Route::get('/pesertaOnline', 'LaporanController@pesertaOnline');

    Route::post('/save-token', 'DashboardController@saveToken')->name('save-token');

    Route::get('/cek/komisi', 'KomisiController@cek')->name('cek');


    Route::get('/eventbaru', function () {
        return view('event.eventbaru');
    });

    Route::any('/logut', function () {
        Auth::logout();
        return redirect('login');
    });

    Route::get('/mail', function () {
        return view('emails.mailprivew');
    });

    Route::get('/test', function () {
        return DB::table("seminars")->count();
        // $notif = App\Helpers\Notifikasi::send(["device_key"=>"8niD7OgjZ737XWh","phone"=>"085232843165","message"=>"test & test","engine"=>"quods","delay"=>1]);
        // return $notif;
    });

    Route::get('/new/{id}', function ($id) {
        $notif = App\Helpers\Whatsapp::start(["token" => (string)$id]);
        return $notif;
    });

    Route::get('/logout/{id}', function ($id) {
        $db = App\Models\Device::where('id', $id)->update(["status" => "Start", "phone" => null, "profile_url" => null, "nama" => null]);
        $notif = App\Helpers\Whatsapp::logout(["token" => (string)$id]);
        return $notif;
    });

    Route::get('/send/{id}', function ($id) {
        $req = \Request();        
        $notif = App\Helpers\Whatsapp::send(["token" => $id, "phone" => $req->phone ?? "085232843165", "message" => "Test server whatsapp from https://seminar.co.id"]);
        return $notif;
    });
});

Route::get('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');
Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');
Route::get('/fcm', function () {
    $data = [
        "title" => "Test FCM",
        "body" => "Pendaftar Baru",
        "image" => "https://cdns.klimg.com/dream.co.id/resized/640x320/news/2019/05/17/108124/tips-dapatkan-foto-keren-saat-traveling-1905170.jpg"
    ];
    $notif = App\Helpers\Notifikasi::fcmAll($data);
});

Route::get('/zoom',function(){
    return HelperZoom::users();
});