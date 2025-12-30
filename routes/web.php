<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\MyPostsController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdoptionController;
use App\Models\AdoptionPet;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\FoundPetController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/findpet', function () {
    return view('module.findpet');
});

Route::get('/report', function () {
    return view('module.report');
});

Route::get('/about', function () {
    return view('module.about_us');
});

Route::get('/contact', function () {
    return view('module.contact_us');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Sign Up
Route::get('/signup', [RegisterController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [RegisterController::class, 'signup']);

// Login
//admin passwpord: admin123456


// Show login form
Route::get('/login', function () {
    return view('auth.login'); // change to your actual login view name
})->name('login');

// Handle login submission
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->filled('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        // Redirect based on admin status
        if (Auth::user()->is_admin == 1) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/homepage');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email'));
});







// Forgot Password
Route::get('/forgotpassword', function () {
    return view('auth.forgotpassword');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// Search Routes
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('/search/suggestions', [App\Http\Controllers\SearchController::class, 'search'])->name('search.suggestions');


Route::get('/test-pets', function () {
    $pets = AdoptionPet::where('is_adopted', false)->latest()->paginate(12);
    return view('adoption.index', compact('pets'));
})->name('test.pets');



/*
|--------------------------------------------------------------------------
| Protected Routes (Require Authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Homepage

    Route::get('/homepage', [App\Http\Controllers\HomeController::class, 'index'])->name('homepage');

    // Admin Dashboard
    Route::get('/dashboard', [AdminVerificationController::class, 'dashboard'])->name('admin.dashboard');

    // Report Routes
    Route::get('/report_lost', function() {
        return view('nav.report_lost');
    });
    


    Route::get('/found/{foundPet}', [App\Http\Controllers\FoundPetController::class, 'show'])->name('found.show');



    // Report Routes
    Route::middleware('auth')->group(function () {
    Route::get('/report_lost', [App\Http\Controllers\LostPetController::class, 'create'])->name('lost.create');
    Route::post('/report_lost', [App\Http\Controllers\LostPetController::class, 'store'])->name('lost.store');

    Route::get('/lost/{lostPet}', [App\Http\Controllers\LostPetController::class, 'show'])->name('lost.show');
    Route::get('/lost/{lostPet}/edit', [App\Http\Controllers\LostPetController::class, 'edit'])->name('lost.edit');
    Route::patch('/lost/{lostPet}', [App\Http\Controllers\LostPetController::class, 'update'])->name('lost.update');
    Route::delete('/lost/{lostPet}', [App\Http\Controllers\LostPetController::class, 'destroy'])->name('lost.destroy');
    });


    //report found pet
   Route::middleware('auth')->group(function () {
    Route::get('/report_found', [FoundPetController::class, 'create'])->name('found.create');
    Route::post('/report_found', [FoundPetController::class, 'store'])->name('found.store');

    Route::get('/found/{foundPet}', [FoundPetController::class, 'show'])->name('found.show');
    Route::get('/found/{foundPet}/edit', [FoundPetController::class, 'edit'])->name('found.edit');
    Route::patch('/found/{foundPet}', [FoundPetController::class, 'update'])->name('found.update');
});





    // Adoption Routes
   
    Route::get('/adoption', [AdoptionController::class, 'dashboard'])->name('adoption.dashboard');
    Route::get('/adoption/index', [AdoptionController::class, 'index'])->name('adoption.index');
    Route::get('/adoption/{adoptionPets}/edit', [AdoptionController::class, 'edit'])->name('adoption.edit');    
    Route::post('/adoption/pets', [AdoptionController::class, 'store'])->name('adoption.store');
    Route::get('/adoption/pets/{pet}', [AdoptionController::class, 'show'])->name('adoption.show');



    // Lost Pet Routes
    Route::get('/dashboardL', function(){
        return view('lost.dashboard');
    });


    Route::get('/indexL', function(){
        return view('lost.index');
    });

    Route::get('/showL', function(){
        return view('lost.show');
    });

    /*
    |--------------------------------------------------------------------------
    | Profile Module
    |--------------------------------------------------------------------------
    */
    
    // Profile
    //Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
    
    // My Pets
    Route::get('/mypets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/mypets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/mypets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/mypets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/mypets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/mypets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
    
    // MyPost 

    Route::middleware('auth')->get('/my-posts', [MyPostsController::class, 'index'])->name('my-posts.index');


    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'conversation']);
    Route::post('/messages/send', [MessageController::class, 'send']);
    Route::get('/search-users', [MessageController::class, 'searchUsers']);
});

    


 /*
    |--------------------------------------------------------------------------
    | Home Controller Route
    |--------------------------------------------------------------------------
    */
    

/*
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/homepage', [HomeController::class, 'index']);

*/







/*
|--------------------------------------------------------------------------
| Verification/Admin Routes
|--------------------------------------------------------------------------
*/

// Normal user verification
Route::middleware('auth')->group(function () {
    Route::get('/verifications', [VerificationController::class, 'index'])->name('verifications.dashboard');
    Route::post('/verifications/submit', [VerificationController::class, 'submit'])->name('verifications.submit');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminVerificationController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/verifications', [AdminVerificationController::class, 'index'])->name('admin.verifications.index');

    Route::post('/verifications/{user}/approve', [AdminVerificationController::class, 'approve'])->name('admin.verifications.approve');

    Route::post('/verifications/{user}/reject', [AdminVerificationController::class, 'reject'])->name('admin.verifications.reject');
});

Route::get('/make-admin', function () {
    auth()->user()->update(['is_admin' => true]);
    return 'You are now admin!';
})->middleware('auth');
