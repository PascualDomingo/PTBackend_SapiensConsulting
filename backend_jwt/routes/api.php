<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ruta prueba hola mundo
Route::get('/test', function(){
    return 'hola mundo v2';
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
});


Route::get('/movies/top', [MovieController::class, 'getLatestMovies']);
Route::get('/movies/buscar/nombre', [MovieController::class, 'searchMovies']);
Route::get('/movies/favorito', [MovieController::class, 'marcarPeliFavorita']);
Route::get('/movies/lista/favorito', [MovieController::class, 'obtenerPeliculasFavoritas']);
