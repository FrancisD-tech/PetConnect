<?php

namespace App\Http\Controllers;

use App\Models\AdoptionPet;
use Illuminate\Http\Request;

class AdoptionPetController extends Controller
{
    public function show(AdoptionPet $adoptionPet)
    {
        return view('adoption.show', compact('adoptionPet'));
    }
}