<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <style>body { background: #000000; color: #ffffff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; } .card { background: #111; padding: 30px; border-radius: 8px; border: 1px solid #ffb703; } input { display: block; margin: 10px 0; padding: 10px; width: 100%; box-sizing: border-box; } button { background: #ffb703; border: none; padding: 10px; width: 100%; cursor: pointer; font-weight: bold; }</style>
</head>
<body>
    <div class="card">
        <h2>Créer un compte</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p><a href="{{ route('login') }}" style="color: #ffb703;">Déjà un compte ? Connexion</a></p>
    </div>
</body>
</html>