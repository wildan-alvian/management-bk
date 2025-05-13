<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->paginate(10);

        $unreadNotifications = Notification::getUnread();
        $unreadCount = $unreadNotifications->count();
        
        $unreadNotifications->update([
            'status' => true,
        ]);

        return view('notification.index', compact('notifications', 'unreadCount'));
    }
}
