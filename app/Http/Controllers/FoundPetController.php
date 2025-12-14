<?php

namespace App\Http\Controllers;

use App\Models\FoundPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoundPetController extends Controller
{
    public function show(FoundPet $foundPet)
    {
        return view('found.show', compact('foundPet'));
    }

    public function create()
    {
        return view('nav.report_found');
    }

    public function store(Request $request)
    {
        $request->validate([
            'species' => 'required|string',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'approximate_age' => 'nullable|string|max:50',
            'gender' => 'required|in:male,female,unknown',
            'description' => 'nullable|string',
            'found_location' => 'required|string|max:255',
            'found_date' => 'required|date',
            'contact_phone' => 'required|string|max:50',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('found_pets', 'public');
            }
        }

        FoundPet::create([
            'user_id' => Auth::id(),
            'species' => $request->species,
            'breed' => $request->breed,
            'color' => $request->color,
            'approximate_age' => $request->approximate_age,
            'gender' => $request->gender,
            'description' => $request->description,
            'found_location' => $request->found_location,
            'found_date' => $request->found_date,
            'contact_phone' => $request->contact_phone,
            'image' => !empty($imagePaths) ? $imagePaths[0] : null,
        ]);

        return redirect('homepage')->with('success', 'Found pet report submitted! We are notifying the owners.');
    }
}