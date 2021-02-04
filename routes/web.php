<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/tournaments', [App\Http\Controllers\TournamentController::class, 'index'])->name('tournaments');
Route::post('/tournaments', [App\Http\Controllers\TournamentController::class, 'new'])->name('tournament.new');
