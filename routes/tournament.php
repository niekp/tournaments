<?php
use Illuminate\Support\Facades\Route;

Route::get('/tournaments', [App\Http\Controllers\TournamentController::class, 'index'])->name('tournaments');
Route::post('/tournaments', [App\Http\Controllers\TournamentController::class, 'new'])->name('tournament.new');
Route::get('/tournaments/edit/{id}', [App\Http\Controllers\TournamentController::class, 'edit'])->name('tournament.edit');
Route::post('/tournaments/edit/{id}', [App\Http\Controllers\TournamentController::class, 'editSave'])->name('tournament.edit.save');
Route::post('/tournaments/delete/{id}', [App\Http\Controllers\TournamentController::class, 'delete'])->name('tournament.delete');

