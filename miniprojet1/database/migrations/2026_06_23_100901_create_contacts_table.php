<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('contacts', function (Blueprint $table) {
        $table->id();
        // Clé étrangère pour lier le contact à un utilisateur
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->string('nom');
        $table->string('prenom');
        $table->string('telephone');
        $table->string('email')->nullable(); // Optionnel selon ton choix
        $table->enum('categorie', ['famille', 'ami', 'pro']); // Les 3 catégories de la consigne
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
