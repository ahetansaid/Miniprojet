<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // 1. Lister les contacts de l'utilisateur connecté (+ Tri)
    public function index(Request $request) {
        $user = Auth::user();
        
        // Gestion du tri (A-Z par défaut)
        $ordre = $request->get('sort', 'asc') === 'desc' ? 'desc' : 'asc';
        
        // Sécurité : Chaque utilisateur ne voit QUE ses propres contacts
        $contacts = $user->contacts()->orderBy('nom', $ordre)->get();

        return view('contacts.index', compact('contacts', 'ordre'));
    }

    // 2. Enregistrer un nouveau contact
    public function store(Request $request) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'categorie' => 'required|in:famille,ami,pro',
        ]);

        // Sécurité : On injecte automatiquement l'ID de l'utilisateur connecté
        Auth::user()->contacts()->create($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contact ajouté !');
    }

    // 3. Mettre à jour un contact
    public function update(Request $request, Contact $contact) {
        // Sécurité : On vérifie que le contact appartient bien à l'utilisateur
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'categorie' => 'required|in:famille,ami,pro',
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contact modifié !');
    }

    // 4. Supprimer un contact
    public function destroy(Contact $contact) {
        // Sécurité
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact supprimé !');
    }
}