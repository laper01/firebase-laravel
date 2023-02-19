<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class NotificationSendController extends Controller
{
    //
    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_token = $request->token;
        Auth::user()->save();
        return response()->json(['token berhasil dibuat']);
    }

    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/test-laravel-push/messages:send';

        $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $serverKey = 'BE17vf9upBTbi8FAz9gjO-em-Bk7e4SxwdzjA4dHV4-9rvQU5EgTitYXgPD6Yinf2PiHCKYhYN8782GbskCEoUs'; // ADD SERVER KEY HERE PROVIDED BY FCM

        // dd($serverKey);

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization: Bearer ya29.' . $serverKey,
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
