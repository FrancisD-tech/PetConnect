<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('pet')->get();
        return view('profile.favorites', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id',
        ]);

        // Check if already favorited
        $exists = Favorite::where('user_id', Auth::id())
                         ->where('pet_id', $request->pet_id)
                         ->exists();

        if ($exists) {
            return back()->with('error', 'Already in favorites!');
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'pet_id' => $request->pet_id,
        ]);

        return back()->with('success', 'Added to favorites!');
    }

    public function destroy(Favorite $favorite)
    {
        if ($favorite->user_id !== Auth::id()) {
            abort(403);
        }

        $favorite->delete();

        return back()->with('success', 'Removed from favorites!');
    }
}