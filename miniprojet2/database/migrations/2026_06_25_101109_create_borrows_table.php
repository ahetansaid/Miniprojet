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
    Schema::create('borrows', function (Blueprint $table) {
        $table->id();
        // Liaison avec l'utilisateur qui emprunte
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Liaison avec le livre emprunté
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
        $table->timestamp('borrowed_at')->useCurrent();
        $table->timestamp('returned_at')->nullable(); // Reste null tant que le livre n'est pas rendu
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
