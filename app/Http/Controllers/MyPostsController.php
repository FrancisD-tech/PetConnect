<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPostsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $lostPets = $user->lostPets()->latest()->get();
        $foundPets = $user->foundPets()->latest()->get();
        $adoptionPets = $user->adoptionPets()->latest()->get();

        return view('profile.mypost', compact('lostPets', 'foundPets', 'adoptionPets'));
    }
}