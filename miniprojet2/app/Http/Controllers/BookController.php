<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET /api/books (Liste de tous les livres)
    public function index()
    {
        return response()->json(Book::all(), 200);
    }

    // POST /api/books (Ajouter un livre - Protégé)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'available_copies' => 'required|integer|min:0',
        ]);

        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Livre ajouté avec succès',
            'book' => $book
        ], 201);
    }

    // GET /api/books/{id} (Afficher un livre spécifique)
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livre non trouvé'], 404);
        }

        return response()->json($book, 200);
    }

    // PUT /api/books/{id} (Modifier un livre - Protégé)
    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livre non trouvé'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|unique:books,isbn,' . $id,
            'available_copies' => 'sometimes|required|integer|min:0',
        ]);

        $book->update($request->all());

        return response()->json([
            'message' => 'Livre mis à jour avec succès',
            'book' => $book
        ], 200);
    }

    // DELETE /api/books/{id} (Supprimer un livre - Protégé)
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Livre non trouvé'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Livre supprimé avec succès'], 200);
    }
}