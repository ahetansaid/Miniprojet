<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création de l'administrateur
        User::factory()->create([
            'name' => 'Admin Bibliothèque',
            'email' => 'admin@exemple.com',
            'password' => Hash::make('password123'),
            'role' => 'admin', // Optionnel, si tu as une colonne role
        ]);

        // 2. Création des 3 utilisateurs de démonstration
        User::factory()->create([
            'name' => 'Jean Dupont',
            'email' => 'jean@exemple.com',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Marie Kone',
            'email' => 'marie@exemple.com',
            'password' => Hash::make('password123'),
        ]);

        User::factory()->create([
            'name' => 'Lucas Mensah',
            'email' => 'lucas@exemple.com',
            'password' => Hash::make('password123'),
        ]);

        // 3. Création des 5 catégories
        Category::factory()->count(5)->create();

        // 4. Création des 20 livres associés aléatoirement aux catégories
        Book::factory()->count(20)->create();
    }
}
