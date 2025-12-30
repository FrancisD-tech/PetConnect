<?php

namespace App\Http\Controllers;

use App\Models\LostPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LostPetController extends Controller
{   
    public function show(LostPet $lostPet)
    {
        return view('lost.show', compact('lostPet'));
    }

    public function create()
    {
        return view('nav.report_lost');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string',
            'breed' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'required|in:male,female,unknown',
            'description' => 'nullable|string',
            'last_seen_location' => 'required|string|max:255',
            'last_seen_date' => 'required|date',
            'contact_phone' => 'required|string|max:50',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle multiple images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('lost_pets', 'public');
            }
        }

        LostPet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'species' => $request->species,
            'breed' => $request->breed,
            'color' => $request->color,
            'age' => $request->age,
            'gender' => $request->gender,
            'description' => $request->description,
            'last_seen_location' => $request->last_seen_location,
            'last_seen_date' => $request->last_seen_date,
            'contact_phone' => $request->contact_phone,
            'image' => !empty($imagePaths) ? $imagePaths[0] : null, // Store first image
        ]);

        return redirect('homepage')->with('success', 'Lost pet report submitted successfully!')
                                 ->with('alert', true);
    }
}