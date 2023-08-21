<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/search', function (Request $request) {

    //return $request->input("query");
    $query = "https://api.watchmode.com/v1/autocomplete-search/?apiKey=". env('WATCHMODE_KEY') . 
    "&search_field=name&search_value=". $request->input('query');
    

    $response = Http::get($query);
    return $response->json();

    return view('pages.results');
});

Route::get('/movie', function () {
    return view('pages.single');
});