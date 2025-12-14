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
}