<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


# API de Gestion de Bibliothèque Électronique

Ce projet est une API REST robuste développée avec Laravel permettant de gérer les livres, les utilisateurs et le cycle complet des emprunts et retours. Elle intègre une authentification sécurisée via Laravel Sanctum.

Fonctionnalités Principales
-Authentification : Inscription, connexion et déconnexion sécurisées.
-Gestion des livres : CRUD complet réservé aux utilisateurs authentifiés.
-Gestion des emprunts : Système d'emprunt en temps réel avec mise à jour automatique des stocks.
-Règles métiers strictes: Limite maximale de 3 emprunts simultanés par utilisateur et blocage des doublons.
-Historique: Consultation complète de l'historique des emprunts de chaque utilisateur (via requêtes GET).

---

Prérequis
Avant d'installer le projet, assurez-vous de disposer de :
-PHP (version 8.2 ou supérieure)
-Composer
-Un serveur MySQL (XAMPP, WampServer)

---

## Installation et Démarrage

1. Cloner le dépôt
```bash
git clone <URL_DE_TON_DEPOT_GITHUB>
cd api-bibliotheque-laravel

2. Installer les dépendances Composer
Bash
composer install
3. Configurer l'environnement
Copiez le fichier d'exemple .env et configurez vos accès à la base de données :

Bash
cp .env.example .env
Ouvrez le fichier .env et modifiez les lignes suivantes avec vos configurations locales :

Code snippet
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_bibliotheque
DB_USERNAME=root
DB_PASSWORD=
4. Générer la clé d'application
Bash
php artisan key:generate
5. Lancer les migrations et injecter les données de test (Seeder)
Cette commande réinitialise la base de données, applique la structure des tables et injecter automatiquement 1 compte Administrateur, 3 utilisateurs de démonstration, 5 catégories et 20 livres.

Bash
php artisan migrate:fresh --seed
6. Lancer le serveur local
Bash
php artisan serve
L'API est désormais accessible en local sur : http://127.0.0.1:8000

Comptes de Démonstration (Mot de passe unique : password123)
Administrateur : admin@exemple.com

Utilisateur 1 : jean@exemple.com

Utilisateur 2 : marie@exemple.com

Utilisateur 3 : lucas@exemple.com

Comment importer la Collection Postman
Une collection Postman préconfigurée est disponible directement dans le dépôt pour tester rapidement tous les points d'accès (endpoints) sans avoir à les recréer manuellement.

Étape 1 : Importer le fichier
Ouvrez l'application Postman.

En haut à gauche de l'interface, cliquez sur le bouton Import.

Glissez-déposez le fichier situé dans votre projet à l'adresse suivante : postman/collection.json (ou cliquez sur Choose Files pour aller le chercher).

Étape 2 : Structure de la collection
La collection va apparaître dans votre barre latérale gauche avec l'intégralité des requêtes organisées :

POST /api/register (Inscription)

POST /api/login (Connexion)

POST /api/logout (Déconnexion)

GET /api/books (Liste des livres)

POST /api/books (Ajouter un livre)

POST /api/borrows (Emprunter un livre)

PUT /api/borrows/{id}/return (Retourner un livre)

GET /api/borrows/history (Consulter ses emprunts)

Étape 3 : Utilisation des jetons d'authentification
Pour exécuter les routes protégées (comme l'ajout de livres, l'emprunt ou le retour) :

Connectez-vous via la requête POST /api/login.

Copiez la valeur de la clé access_token reçue dans la réponse JSON.

Sur la requête protégée de votre choix, allez dans l'onglet Authorization.

Sélectionnez le type Bearer Token dans le menu déroulant.

Collez votre jeton dans la case Token à droite.

Dans l'onglet Headers, assurez-vous d'avoir la ligne Accept : application/json.

Cliquez sur Send.