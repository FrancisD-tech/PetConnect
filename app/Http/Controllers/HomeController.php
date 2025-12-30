<?php

namespace App\Http\Controllers;

use App\Models\LostPet;
use App\Models\FoundPet;
use App\Models\AdoptablePet;
use Illuminate\Http\Request;
use App\Models\AdoptionPet;

class HomeController extends Controller
{
    public function index()
    {
        // For logged-in user: possible matches (simplified)
        $userLostPets = auth()->check() ? auth()->user()->lostPets()->where('is_reunited', false)->get() : collect();

        $possibleMatches = collect();
        if ($userLostPets->isNotEmpty()) {
            // Simple match logic (you can improve with AI later)
            $possibleMatches = FoundPet::where('is_claimed', false)
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        $recentLost = LostPet::where('is_reunited', false)->latest()->take(8)->get();
        $recentFound = FoundPet::where('is_claimed', false)->latest()->take(8)->get();
        $adoptable = AdoptionPet::where('is_adopted', false)->inRandomOrder()->take(8)->get();

        $urgentCount = LostPet::whereDate('lost_date', today())->count();

        return view('homepage', compact(
            'possibleMatches',
            'recentLost',
            'recentFound',
            'adoptable',
            'urgentCount'
        ));
    }
}
