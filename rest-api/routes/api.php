<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/api/v1/pokemons', "PokemonController@index");

Route::controller(PokemonController::class)->group(function () {
    Route::get('/v1/pokemons/{id}', 'show');
    Route::get('/v1/pokemons/', 'index');
    Route::get('/v1/search', 'search');
});

Route::controller(TeamController::class)->group(function () {
    Route::get('/v1/teams', 'index');
    Route::post('/v1/teams', 'create');
    Route::get('/v1/teams/{id}', 'show');
    Route::post('/v1/teams/{id}', 'update');
    Route::get('/v1/teams/delete/{id}', 'destroy');
});