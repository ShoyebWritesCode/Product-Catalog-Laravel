<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{

    public function storeToken(Request $request)
    {
        $admin = Auth::user();
        $user_id  = $admin->id;
        Log::info($user_id);
        $user = Admin::find($user_id);

        $user->update([
            'fcm_token' => $request->token
        ]);

        return response()->json($request);
    }

    public function sendPushNotification()
    {
        $admin = Auth::user();
        $user_id  = $admin->id;
        $user = Admin::find($user_id);
        $fcmToken = $user->fcm_token;
        $firebase = (new Factory)
            ->withServiceAccount('C:/xampp/htdocs/auth_app/config/firebase_credentials.json');


        $messaging = $firebase->createMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => 'Hello from Firebase!',
                'body' => 'This is a test notification.'
            ],
            'token' => $fcmToken
        ]);

        $messaging->send($message);

        return response()->json([
            'message' => 'Push notification sent successfully,',
            'token' => $fcmToken
        ]);
    }
}
