<?php

namespace App\Http\Controllers;

use App\Models\AdoptionPet;
use Illuminate\Http\Request;

class AdoptionController extends Controller
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

        return view('adoption.show', compact('pet'));
    }

    public function store(Request $request)
    {
        \Log::info('Adoption store called', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age_months' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image_main' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image_main')->store('pets', 'public');

        AdoptionPet::create([
            'name' => $request->name,
            'breed' => $request->breed,
            'age_months' => $request->age_months,
            'gender' => $request->gender,
            'location' => $request->location,
            'description' => $request->description,
            'image_main' => $path,
            'is_adopted' => false,
        ]);

        return redirect()->route('adoption.index')->with('success', 'Pet posted for adoption successfully!');
    }
}