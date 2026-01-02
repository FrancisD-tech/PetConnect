<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get all messages involving the current user
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get();

        // Group by the other user in the conversation
        $conversations = $messages->groupBy(function ($message) use ($userId) {
            return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
        })->map(function ($group, $otherUserId) {
        $latestMessage = $group->first();
        $otherUser = User::find($otherUserId);

        // Count how many unread messages in this conversation
        $unreadCount = Message::where('sender_id', $otherUserId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return [
            'id' => $otherUserId,
            'name' => $otherUser?->name ?? 'Unknown User',
            'profile_photo_path' => $otherUser?->profile_photo_path,
            'last_message' => $latestMessage->message,
            'last_time' => $latestMessage->created_at,
            'unread_count' => $unreadCount,  // ← NEW
        ];
    })->values();

        return view('profile.messages', compact('conversations'));
    }

    public function searchUsers(Request $request)
    {
        $query = $request->q;
        $users = User::where('name', 'like', "$query%")
                     ->where('id', '!=', auth()->id())
                     ->limit(10)
                     ->select('id', 'name')
                     ->get();

                return response()->json($users);
    }


    public function conversation($userId)
    {
        $messages = Message::where(function ($q) use ($userId) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        // Broadcast event here for real-time
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['success' => true]);
    }

    public function show(User $user)
    {
        $messages = Message::where(function($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
               ->where('receiver_id', Auth::id())
               ->where('is_read', false)
               ->update(['is_read' => true]);

        return view('profile.chat', compact('messages', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent!');
    }

    public function markAsRead($otherUserId)
    {
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    
}