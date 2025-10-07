<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BattleController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes pour les Battles
Route::resource('battles', BattleController::class);

// Routes pour les Mèmes
Route::get('/battles/{battle}/memes/create', [MemeController::class, 'create'])
    ->name('memes.create');
Route::post('/battles/{battle}/memes', [MemeController::class, 'store'])
    ->name('memes.store');
Route::get('/memes/{meme}', [MemeController::class, 'show'])
    ->name('memes.show');
Route::delete('/memes/{meme}', [MemeController::class, 'destroy'])
    ->name('memes.destroy');

// Routes pour les Votes
Route::post('/memes/{meme}/votes', [VoteController::class, 'store'])
    ->name('votes.store');
Route::delete('/memes/{meme}/votes', [VoteController::class, 'destroy'])
    ->name('votes.destroy');

require __DIR__.'/auth.php';