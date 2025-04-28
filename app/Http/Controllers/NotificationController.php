<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    public function markAllAsRead()
    {
        $userId = auth()->user()->id;

        $notifications = Notification::where('user_id', $userId)->where('status', 'unread')->get();

        if ($notifications->count() < 1) {
            return redirect()->back()->with('error', 'Something went wrong!');
        } else {
            foreach ($notifications as $notification) {
                $notification->status = 'read';
                $notification->save();
            }
            return redirect()->back()->with('success', 'All Notifications set to read');
        }
    }
}
