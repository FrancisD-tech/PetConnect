<?php

namespace App\Http\Controllers;

use App\Models\AdoptionPet;
use Illuminate\Http\Request;

class AdoptionPetController extends Controller
{
    public function dashboard()
    {
        $available = AdoptionPet::where('is_adopted', false)->count();
        $adopted = AdoptionPet::where('is_adopted', true)->count();
        $total = AdoptionPet::count();

        return view('adoption.dashboard', compact('available', 'adopted', 'total'));
    }

    public function index(Request $request)
    {
        $pets = AdoptionPet::where('is_adopted', false)
            ->when($request->species, fn($q, $s) => $q->where('species', $s))
            ->when($request->gender, fn($q, $g) => $q->where('gender', $g))
            ->latest()
            ->paginate(12);

        return view('adoption.index', compact('pets'));
    }

    public function show(AdoptionPet $pet)
    {
        if ($pet->is_adopted) {
            return redirect()->route('adoption.index')->with('error', 'This pet has been adopted!');
        }

        return view('adoption.index', compact('pet'));
    }
}