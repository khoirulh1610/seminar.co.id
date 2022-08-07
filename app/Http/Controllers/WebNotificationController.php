<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class WebNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('dashboard');
    }
  
    public function storeToken(Request $request)
    {
        Auth::user()->update(['device_token'=>$request->token]);
        return response()->json(['Token successfully stored : '.$request->token]);
    }
  
    public function sendWebNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::where('role_id','<=',3)->whereNotNull('device_token')->pluck('device_token')->all();
          
        $serverKey = 'AAAATi93QOI:APA91bGaMyVJXtUWPJ2MxFN28ycoP_q4e1XY8VHgLz_iqCKDjgpYIuctJV8USdXaugAbpMnYENE6E3wvt8_5ytsuMMC_pBYC0tsR-WpZQzuPtgm5wRDBNUvObCdseivdSXj8I8CD-dty';
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        

        // Close connection
        curl_close($ch);

        // FCM response
        dd($result);        
    }
}
