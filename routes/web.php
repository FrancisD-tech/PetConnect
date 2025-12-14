<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\HomeController;

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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

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

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Homepage
    Route::get('/homepage', function() {
        return view('homepage');
    })->name('homepage');

    Route::get('/homepage', [App\Http\Controllers\HomeController::class, 'index'])->name('homepage');

    // Report Routes
    Route::get('/report_lost', function() {
        return view('nav.report_lost');
    });
    
    //view individual pet pages
    Route::get('/lost/{lostPet}', [App\Http\Controllers\LostPetController::class, 'show'])->name('lost.show');
    Route::get('/found/{foundPet}', [App\Http\Controllers\FoundPetController::class, 'show'])->name('found.show');
    Route::get('/adoption/{adoptionPet}', [App\Http\Controllers\AdoptionPetController::class, 'show'])->name('adoption.show');



    // Report Routes
    Route::get('/report_lost', [App\Http\Controllers\LostPetController::class, 'create'])->name('lost.create');
    Route::post('/report_lost', [App\Http\Controllers\LostPetController::class, 'store'])->name('lost.store');



    //report ofun
    Route::get('/report_found', [App\Http\Controllers\FoundPetController::class, 'create'])->name('found.create');
    Route::post('/report_found', [App\Http\Controllers\FoundPetController::class, 'store'])->name('found.store');



    Route::get('/report_found', function() {
        return view('nav.report_found');
    });



    // Adoption Routes
    Route::get('/dashboard', function(){
        return view('adoption.dashboard');
    });

    Route::get('/index', function(){
        return view('adoption.index');
    });

    Route::get('/show', function(){
        return view('adoption.show');
    });

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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    // My Pets
    Route::get('/mypets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/mypets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/mypets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/mypets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/mypets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/mypets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
    
    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    
    // Messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});


 /*
    |--------------------------------------------------------------------------
    | Home Controller Route
    |--------------------------------------------------------------------------
    */
    
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/homepage', [HomeController::class, 'index']);