<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('verification.index', compact('user'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'id_type' => 'required|in:national_id,drivers_license,passport,other',
            'government_id' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5048', // 5MB max
        ]);

        $path = $request->file('government_id')->store('verifications', 'public');

        auth()->user()->update([
            'full_name' => $request->full_name,
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'id_type' => $request->id_type,
            'government_id' => $path,
            'verification_status' => 'unverified',
        ]);

        return redirect()->back()->with('success', 'Verification submitted! Admin will review it soon.');
    }
}   