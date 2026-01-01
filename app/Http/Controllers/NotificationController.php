<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        // Mark all as read when viewing (optional)
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return view('notifications.index    ', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = auth()->user()->notifications()->findOrFail($id);
        $notif->update(['is_read' => true]);

        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'All notifications marked as read!');
    }
}