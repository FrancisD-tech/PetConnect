<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        $pets = Auth::user()->pets;
        return view('profile.mypets', compact('pets'));
    }

    public function create()
    {
        return view('profile.add-pet');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'microchip' => 'nullable|string',
            'vaccinated' => 'boolean',
            'neutered' => 'boolean',
        ]);

        $imagePath = $request->file('image')->store('pets', 'public');

        Pet::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'breed' => $request->breed,
            'gender' => $request->gender,
            'age' => $request->age,
            'image' => $imagePath,
            'microchip' => $request->microchip,
            'vaccinated' => $request->has('vaccinated'),
            'neutered' => $request->has('neutered'),
        ]);

        return redirect()->route('pets.index')->with('success', 'Pet added successfully!');
    }

    public function edit(Pet $pet)
    {
        // Check if user owns this pet
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('profile.edit-pet', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'age' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $pet->delete();

        return redirect()->route('profile.mypost')->with('success', 'Pet deleted successfully!');
    }
}