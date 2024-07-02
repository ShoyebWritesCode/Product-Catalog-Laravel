<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()->notifications;
        $unreadNotifications = auth()->user()->notifications->whereNull('read_at');
        $readNotifications = auth()->user()->notifications->whereNotNull('read_at');

        return view('admin.notifications', [
            'notifications' => $notifications,
            'unreadNotifications' => $unreadNotifications,
            'readNotifications' => $readNotifications,
        ]);
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All Notification marked as read.');
    }

    public function markAsReadCus($id)
    {
        $notifications = auth()->user()->notifications;
        $notification = $notifications->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notification marked as read.');
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
    }

    public function delete($id)
    {
        $notifications = auth()->user()->notifications;
        $notification = $notifications->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Notification deleted.');
        }

        return response()->json(['success' => false, 'message' => 'Notification not found.'], 404);
    }
}
