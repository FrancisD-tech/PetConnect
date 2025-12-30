<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVerificationController extends Controller
{
    public function dashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalAdoptable = \App\Models\AdoptionPet::count();
        $totalLost = \App\Models\LostPet::count();
        $totalFound = \App\Models\FoundPet::count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdoptable',
            'totalLost',
            'totalFound'
        ));
    }

    public function index()
    {
        $pendingUsers = User::where('verification_status', 'unverified')->get();
        $verifiedUsers = User::where('verification_status', 'verified')->latest('verified_at')->take(10)->get();
        $rejectedUsers = User::where('verification_status', 'unverified')->latest('updated_at')->take(10)->get();
        
        return view('admin.verifications.index', compact('pendingUsers', 'verifiedUsers', 'rejectedUsers'));
    }

    public function approve(User $user)
    {
        $user->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', "{$user->name} has been verified successfully!");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $user->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // In approve()
    $user->update([
        'verification_status' => 'verified',
        'verified_at' => now(),
        'rejection_reason' => null,
    ]);

    // In reject()
    $user->update([
        'verification_status' => 'rejected',
        'rejection_reason' => $request->rejection_reason,
    ]);

        return back()->with('success', "{$user->name}'s verification has been rejected.");
    }
}