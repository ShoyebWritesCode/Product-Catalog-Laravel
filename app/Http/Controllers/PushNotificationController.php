<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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

        $latestOrder = Order::latest()->first();
        $latestOrder->update([
            'is_pushed' => 0
        ]);
        $latestOrder->save();

        $signedUrl = URL::temporarySignedRoute(
            'admin.order.show',
            now()->addMinutes(30),
            ['order' => $latestOrder->id]
        );
        $messaging = $firebase->createMessaging();

        $message = CloudMessage::fromArray([
            'notification' => [
                'title' => 'New Order',
                'body' => 'You have received a new order.Order ID is ' . $latestOrder->id
            ],
            'data' => [
                'url' => $signedUrl
            ],
            'token' => $fcmToken
        ]);

        $messaging->send($message);

        return response()->json([
            'message' => 'Push notification sent successfully,',
            'token' => $fcmToken
        ]);
    }

    public function checkNewOrder()
    {
        $latestOrder = Order::where('is_pushed', 1)->latest()->first();

        if ($latestOrder) {
            return response()->json([
                'new_order' => true,
                'order_id' => $latestOrder->id
            ]);
        }

        return response()->json([
            'new_order' => false
        ]);
    }
}
