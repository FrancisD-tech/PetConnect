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
            'pet_name' => $request->name,
            'species' => $request->species,
            'breed' => $request->breed,
            'color' => $request->color,
            'age' => $request->age,
            'gender' => $request->gender,
            'description' => $request->description,
            'last_seen_location' => $request->last_seen_location,
            'lost_date' => $request->last_seen_date,
            'contact_phone' => $request->contact_phone,
            'image' => !empty($imagePaths) ? $imagePaths[0] : null, // Store first image
            'is_reunited' => false,
        ]);

        return redirect('homepage')->with('success', 'Lost pet report submitted successfully!')
                                 ->with('alert', true);
    }

    public function update(Request $request, LostPet $lostPet)
    {
        // Only allow the owner to update
        if (auth()->id() !== $lostPet->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age_months' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'last_seen_location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'name', 'breed', 'age_months', 'gender',
            'last_seen_location', 'description', 'lat', 'lng'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($lostPet->image) {
                Storage::disk('public')->delete($lostPet->image);
            }
            $data['image'] = $request->file('image')->store('lost-pets', 'public');
        }

        $lostPet->update($data);

        return redirect()->route('lost.show', $lostPet)->with('success', 'Lost pet report updated successfully!');
    }

    public function edit(LostPet $lostPet)
    {
        if (auth()->id() !== $lostPet->user_id) {
            abort(403);
        }

        return view('nav.report_lost', compact('lostPet'));
    }
}