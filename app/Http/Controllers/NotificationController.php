<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');

        $rawNotifications = Notification::orderBy('created_at', 'desc')
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            });

        $notifications = $rawNotifications->paginate(10);
        $unreadCount = $rawNotifications->where('status', false)->count();

        return view('notification.index', compact('notifications', 'unreadCount'));
    }

    public function read($id) {
        Notification::find($id)->update([
            'status' => true,
        ]);

        return redirect()->route('counseling.index');
    }
}
