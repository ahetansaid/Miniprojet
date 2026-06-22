<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Models\Contact; // <-- Ne pas oublier d'importer le modèle Contact !
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard mise à jour avec le décompte des contacts
Route::get('/dashboard', function () {
    $totalContacts = Contact::where('user_id', Auth::id())->count();

    return view('dashboard', compact('totalContacts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('contacts', ContactController::class)->middleware(['auth']);