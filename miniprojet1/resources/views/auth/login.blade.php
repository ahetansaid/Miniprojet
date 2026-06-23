<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>body { background: #000000; color: #ffffff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; } .card { background: #111; padding: 30px; border-radius: 8px; border: 1px solid #ffb703; } input { display: block; margin: 10px 0; padding: 10px; width: 100%; box-sizing: border-box; } button { background: #ffb703; border: none; padding: 10px; width: 100%; cursor: pointer; font-weight: bold; } .error { color: #ff4d4d; }</style>
</head>
<body>
    <div class="card">
        <h2>Connexion</h2>
        
        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
        <p><a href="{{ route('register') }}" style="color: #ffb703;">Pas de compte ? S'inscrire</a></p>
    </div>
</body>
</html>