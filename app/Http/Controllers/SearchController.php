<?php

namespace App\Http\Controllers;

use App\Models\LostPet;
use App\Models\FoundPet;
use App\Models\AdoptionPet;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all'); // all, lost, found, adoption

        $results = [];

        if ($type === 'all' || $type === 'lost') {
            $results['lost'] = LostPet::where('is_reunited', false)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('species', 'LIKE', "%{$query}%")
                      ->orWhere('breed', 'LIKE', "%{$query}%")
                      ->orWhere('color', 'LIKE', "%{$query}%")
                      ->orWhere('last_seen_location', 'LIKE', "%{$query}%");
                })
                ->take(5)
                ->get();
        }

        if ($type === 'all' || $type === 'found') {
            $results['found'] = FoundPet::where('is_claimed', false)
                ->where(function($q) use ($query) {
                    $q->where('species', 'LIKE', "%{$query}%")
                      ->orWhere('breed', 'LIKE', "%{$query}%")
                      ->orWhere('color', 'LIKE', "%{$query}%")
                      ->orWhere('found_location', 'LIKE', "%{$query}%");
                })
                ->take(5)
                ->get();
        }

        if ($type === 'all' || $type === 'adoption') {
            $results['adoption'] = AdoptionPet::where('is_adopted', false)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('species', 'LIKE', "%{$query}%")
                      ->orWhere('breed', 'LIKE', "%{$query}%")
                      ->orWhere('color', 'LIKE', "%{$query}%");
                })
                ->take(5)
                ->get();
        }

        return response()->json($results);
    }

    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all');

        $lostPets = [];
        $foundPets = [];
        $adoptionPets = [];

        if ($type === 'all' || $type === 'lost') {
            $lostPets = LostPet::where('is_reunited', false)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('species', 'LIKE', "%{$query}%")
                      ->orWhere('breed', 'LIKE', "%{$query}%")
                      ->orWhere('color', 'LIKE', "%{$query}%")
                      ->orWhere('last_seen_location', 'LIKE', "%{$query}%");
                })
                ->latest()
                ->paginate(12);
        }

        if ($type === 'all' || $type === 'found') {
            $foundPets = FoundPet::where('is_claimed', false)
                ->where(function($q) use ($query) {
                    $q->where('species', 'LIKE', "%{$query}%")
                      ->orWhere('breed', 'LIKE', "%{$query}%")
                      ->orWhere('color', 'LIKE', "%{$query}%")
                      ->orWhere('found_location', 'LIKE', "%{$query}%");
                })
                ->latest()
                ->paginate(12);
        }

        if ($type === 'all' || $type === 'adoption') {
            $adoptionPets = AdoptionPet::where('is_adopted', false)
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('species', 'LIKE', "%{$query}%")
                      ->orWhere('breed', 'LIKE', "%{$query}%")
                      ->orWhere('color', 'LIKE', "%{$query}%");
                })
                ->latest()
                ->paginate(12);
        }

        return view('search.results', compact('query', 'type', 'lostPets', 'foundPets', 'adoptionPets'));
    }
}