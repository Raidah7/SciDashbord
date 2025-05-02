<?php

namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        return view('researcher.notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->where('notification_id', $id)->first();
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
        return back()->with('success', 'Notification marked as read.');
    }

    public function delete($id)
    {
        Notification::where('user_id', Auth::id())->where('notification_id', $id)->delete();
        return back()->with('success', 'Notification deleted.');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }

    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        return back()->with('success', 'All notifications deleted.');
    }
}
