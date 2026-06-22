<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    // Lister uniquement les contacts de l'utilisateur connecté + Gestion du Tri
    public function index(Request $request)
    {
        $sort = $request->get('sort') === 'desc' ? 'desc' : 'asc';
        
        // Sécurité minimale exigée : WHERE user_id = connecté
        $contacts = Auth::user()->contacts()->orderBy('nom', $sort)->get();

        return view('contacts.index', compact('contacts'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('contacts.create');
    }

    // Enregistrer le contact avec validation des données
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'categorie' => 'required|in:famille,ami,pro',
        ]);

        // Création liée à l'utilisateur connecté
        Auth::user()->contacts()->create($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contact ajouté avec succès !');
    }

    // Afficher le formulaire d'édition (avec sécurité d'accès)
    public function edit(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }
        return view('contacts.edit', compact('contact'));
    }

    // Mettre à jour le contact
    public function update(Request $request, Contact $contact)
    {
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

    // Supprimer le contact
    public function destroy(Contact $contact)
    {
        if ($contact->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contact supprimé !');
    }
}