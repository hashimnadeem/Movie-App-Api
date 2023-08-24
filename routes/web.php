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
    $query = $request->input('query');
    $request_url = "https://api.watchmode.com/v1/autocomplete-search/?apiKey=". env('WATCHMODE_KEY') . 
    "&search_field=name&search_value=". $query;
    

    $response = Http::get($request_url);
    $results = $response->json();
    $results = $results['results'];
    return view('pages.results', [
        "results" => $results,
        "query" => ucwords($query)
    ]);
});

Route::get('/{type}/{id}', function (Request $request, $type, $id) {

    //return $request->input("query");
    //$query = $request->input('query');
    $request_url = "https://api.watchmode.com/v1/title/" . $id . "/details/?apiKey=". env('WATCHMODE_KEY') . 
    "&append_to_response=sources";
    

    $response = Http::get($request_url);
    $results = $response->json();
    // return $results['sources'];
    $rent_sources = [];
    $buy_sources = [];
    $stream_sources = [];
    $free_resources = [];

    foreach($results['sources'] as $item) {
        if($item['type'] == 'rent') {
            $rent_sources[] = $item;
        }

        if($item['type'] == 'buy') {
            $buy_sources[] = $item;
        }

        if($item['type'] == 'sub') {
            $stream_sources[] = $item;
        }

        if($item['type'] == 'free') {
            $free_resources[] = $item;
        }
    }

    return view('pages.single', [
        "data" => $results,
        "rent_sources" => $rent_sources,
        "buy_sources" => $buy_sources,
        "stream_sources" => $stream_sources,
        "free_sources" => $free_resources
    ]);
});

Route::get('/movie', function () {
    return view('pages.single');
});