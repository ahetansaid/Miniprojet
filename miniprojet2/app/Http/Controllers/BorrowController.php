<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // POST /api/borrows (Emprunter un livre)
    public function borrowBook(Request $request)
    {

    $request->validate([
            'book_id' => 'required',
        ]);

        $book = Book::find($request->book_id);

    $activeBorrowsCount = Borrow::where('user_id', $user->id)
          ->whereNull('returned_at')
          ->count();

    $_exists = false; // Initialisation pour la logique
    

    if ($activeBorrowsCount >= 3) {
    return response()->json([
        'status' => 'error',
        'message' => 'Limite d\'emprunts atteinte. Vous ne pouvez pas avoir plus de 3 livres empruntés simultanément.'
    ], 400);
}

        

        // Sécurité absolue : vérifier si l'utilisateur est bien authentifié
    if (!$request->user()) {
        return response()->json([
            'message' => 'Authentification requise pour effectuer cette action.'
        ], 401);
    }

        // Sécurité : Si le livre n'existe pas en base de données
    if (!$book) {
        return response()->json([
            'message' => 'Ce livre n\'existe pas dans notre catalogue.'
        ], 404);
    }

        // Vérifier la disponibilité des exemplaires
        if ($book->available_copies < 1) {
            return response()->json([
                'message' => 'Désolé, ce livre n\'est plus disponible pour le moment.'
            ], 400);
        }

        // Créer l'enregistrement de l'emprunt lié à l'utilisateur connecté
        $borrow = Borrow::create([
            'user_id' => $request->user()->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        // Décrémenter les copies disponibles du livre
        $book->decrement('available_copies');

        return response()->json([
            'message' => 'Livre emprunté avec succès.',
            'borrow' => $borrow
        ], 201);

        // Vérifier si l'utilisateur a déjà un emprunt en cours (non rendu) pour ce même livre
$alreadyBorrowed = Borrow::where('user_id', $user->id)
    ->where('book_id', $bookId)
    ->whereNull('returned_at') // returned_at est null signifie que le livre n'a pas encore été rendu
    ->exists();

if ($alreadyBorrowed) {
    return response()->json([
        'status' => 'error',
        'message' => 'Vous avez déjà un exemplaire de ce livre en cours d\'emprunt.'
    ], 400);
}


    }

    // PUT /api/borrows/{id}/return (Retourner un livre)
    public function returnBook($id)
    {
        $borrow = Borrow::find($id);

        if (!$borrow || $borrow->returned_at !== null) {
            return response()->json([
                'message' => 'Emprunt introuvable ou livre déjà retourné.'
            ], 404);
        }

        // Enregistrer la date de retour
        $borrow->update([
            'returned_at' => now(),
        ]);

        // Réincrémenter le stock du livre
        $book = Book::find($borrow->book_id);
        $book->increment('available_copies');

        return response()->json([
            'message' => 'Livre retourné avec succès.',
            'borrow' => $borrow
        ], 200);
        
        
    }


/**
 * Récupérer l'historique des emprunts de l'utilisateur connecté
 */
public function userHistory(Request $request)
{
    // Récupérer l'utilisateur connecté
    $user = $request->user();

    // Récupérer tous les emprunts de cet utilisateur, triés du plus récent au plus ancien
    // 'book' permet de charger en même temps les informations du livre associé
    $borrows = $user->borrows()->with('book')->latest()->get();

    return response()->json([
        'status' => 'success',
        'count' => $borrows->count(),
        'data' => $borrows
    ], 200);
}

}