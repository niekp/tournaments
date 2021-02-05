<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

/* Tournament */
Route::get('/tournaments', [App\Http\Controllers\TournamentController::class, 'index'])->name('tournaments');
Route::post('/tournaments', [App\Http\Controllers\TournamentController::class, 'new'])->name('tournament.new');
Route::get('/tournaments/edit/{id}', [App\Http\Controllers\TournamentController::class, 'edit'])->name('tournament.edit');
Route::post('/tournaments/edit/{id}', [App\Http\Controllers\TournamentController::class, 'editSave'])->name('tournament.edit.save');
Route::post('/tournaments/delete/{id}', [App\Http\Controllers\TournamentController::class, 'delete'])->name('tournament.delete');

/* Games */
Route::get('/games/{guid}', [App\Http\Controllers\GameController::class, 'index'])->name('games');

