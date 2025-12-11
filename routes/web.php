<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/test-supabase', function () {
    $url    = env('SUPABASE_URL') . '/rest/v1';
    $apiKey = env('SUPABASE_KEY');

    $response = Http::withHeaders([
        'apikey'        => $apiKey,
        'Authorization' => 'Bearer ' . $apiKey,
    ])->get($url . '/non_table');

    return $response->json();
});

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

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/forgotpassword', function () {
    return view('forgotpassword');
});


Route::get('/homepage', function() {
    return view('homepage');
});

Route::get('/report_lost', function() {
    return view('nav.report_lost');
});