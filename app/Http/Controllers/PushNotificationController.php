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
        $user = Admin::find($user_id);

        $user->update([
            'fcm_token' => $request->token
        ]);

        return response()->json($request);
    }
}
