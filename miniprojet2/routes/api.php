<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use Illuminate\Support\Facades\Route;

// Routes publiques d'authentification
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// Routes protégées par l'authentification Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});

// Routes publiques pour les livres
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);

// Routes protégées pour les livres
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    
    // Actions de gestion des livres
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Emprunts (Ajouts ici)
    Route::post('/borrows', [BorrowController::class, 'borrowBook']);
    Route::put('/borrows/{id}/return', [BorrowController::class, 'returnBook']);
    Route::get('/borrows/history', [BorrowController::class, 'userHistory']);
});

