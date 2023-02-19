<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationSendController;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('push-notification', [NotificationController::class, 'index']);
Route::post('sendNotification', [NotificationController::class, 'sendNotification'])->name('send.notification');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});

Route::get('test-firebase', function () {
    $topic = 'test';
    $deviceToken = 'eoI5AcEGIGqWf8BkYpoaX1:APA91bFHvh7rY9wf2VqPlRZfeKXduVuJQ7Lqhz0S0Yo7-UsIqIFgP9UUxPcQ5vwGSAAS_K7ehuyOZcABVCdQ2EcsmEbD-wTb-BgiJhi751W0jC_uMdKHfHnRGoNaogvMeSprl_6KCrbn';
    $message = CloudMessage::
        // withTarget('topic', $topic)
        withTarget('token', $deviceToken)
        ->withNotification(Notification::create('coba', 'inoi test tubuh'))
        // ->withAndroidConfig(AndroidConfig::fromArray(['ttl' => '3600s']))
        ->withData(['test' => 'ini test data']);
    // ->withToken('device_token');

    // Membuat instance Firebase Messaging
    $fcm = app('firebase.messaging');

    // Mengirim notifikasi
    $response = $fcm->send($message);
    dd($response);
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
