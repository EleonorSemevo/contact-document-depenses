<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DiagramController;

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
Route::get('/operation', [DepenseController::class, 'depense_totales_2']);

//pour la recherche par mois
Route::post('/month',  [DepenseController::class, 'depenses_mois_2']);

Route::get('/operation/statistiques', [DiagramController::class, 'diagram']);
