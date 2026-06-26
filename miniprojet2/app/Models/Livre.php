<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    //
    public function up(): void
{
    Schema::create('livres', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->string('auteur');
        $table->string('isbn')->unique();
        $table->integer('annee');
        $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
        $table->timestamps();
    });
}
protected $fillable = ['titre', 'auteur', 'isbn', 'annee', 'categorie_id'];
}
