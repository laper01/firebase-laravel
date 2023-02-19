<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Iluminate\Support\Facades\Http;

class NotificationController extends Controller
{
    //

    public function index()
    {
        return view('pushNotification');
    }

    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = [
            'registration_ids' => $firebaseToken,
            'notification' => [
                'title' => $request->title,
                'body' => $request->body
            ]
        ];

        // $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $url = 'https://fcm.googleapis.com/fcm/send';

        // $reponse = Http::
        //     withHeaders($headers)->
        //     post($url, $data);

        //     dd($reponse);
    }


}
