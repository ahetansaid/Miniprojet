<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher le formulaire d'inscription
    public function showRegister() {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hachage sécurisé
        ]);

        return redirect()->route('login')->with('success', 'Inscription réussie, connectez-vous !');
    }

    // Afficher le formulaire de connexion
    public function showLogin() {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérification des identifiants et création de la session
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('contacts.index'); // On redirigera vers la liste des contacts
        }

        // Message d'erreur clair si échec
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}