<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PushNotificationController extends Controller
{

    public function storeToken(Request $request)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);

        $user->update([
            'fcm_token' => $request->token
        ]);

        return response()->json($request);
    }

    public function sendPushNotification()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
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
