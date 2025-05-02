<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())->latest('date')->get();
        return view('admin.notifications', compact('notifications'));
    }

    public function markRead(Request $request)
    {
        $notification = Notification::find($request->notification_id);
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Notification not found'], 404);
    }

    public function delete(Request $request)
    {
        $notification = Notification::find($request->notification_id);
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Notification not found'], 404);
    }

    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function deleteAll()
    {
        Notification::where('user_id', auth()->id())->delete();
        return response()->json(['success' => true]);
    }
}
