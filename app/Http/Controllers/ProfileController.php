<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $pets = $user->pets;
    $favoritesCount = $user->favorites()->count();
    $messagesCount = $user->receivedMessages()->where('is_read', false)->count();
    
    return view('profile.profile', compact('user', 'pets', 'favoritesCount', 'messagesCount'));
}

    public function update(Request $request)
    {
        //dd($request->all(), $request->hasFile('profile_photo'), $request->file('profile_photo'));
        
        $request->validate([
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        
    ]);

    $user = auth()->user();

    if ($request->hasFile('profile_photo')) {
        // Delete old photo
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        // Save path to DB
        $user->profile_photo_path = $path;
        $user->save();

        return back()->with('success', 'Profile photo updated successfully!');
    }

    return back();
    }
}