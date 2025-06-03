<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $type = $request->query('type');

        $notifications = Notification::orderBy('created_at', 'desc')
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($user->hasRole(['Student', 'Student Parents']), function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            });

        $unreadCount = $notifications->where('status', false)->count();

        $notifications = $notifications->paginate(10);

        return view('notification.index', compact('notifications', 'unreadCount'));
    }

    public function read($id) {
        Notification::find($id)->update([
            'status' => true,
        ]);

        return redirect()->route('counseling.index');
    }
}
