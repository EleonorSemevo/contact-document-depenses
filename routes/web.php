<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\RapportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*

Route::get('/operation', function () {
    return view('financeoperation');
});

*/

/*Route::get('/fonc', function () {
    return view ('foonctionnalites');
});*/
Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/operation', [DepenseController::class, 'depense_totales']);

//pour la recherche par mois
Route::post('/month',  [DepenseController::class, 'depenses_mois']);

Route::get('/operation/statistiques', [DiagramController::class, 'index']);
Route::post('/operation/statistiques', [DiagramController::class, 'index']);
Route::get('/operation/rapport', [RapportController::class, 'index']);
Route::post('/operation/rapport', [RapportController::class, 'index']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});