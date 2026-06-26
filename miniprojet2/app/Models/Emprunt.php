<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    public function up(): void
{
    Schema::create('emprunts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('livre_id')->constrained('livres')->onDelete('cascade');
        $table->dateTime('date_emprunt');
        $table->date('date_retour_prevue');
        $table->dateTime('date_retour_effective')->nullable();
        $table->timestamps();
    });
}
    protected $fillable = ['user_id', 'livre_id', 'date_emprunt', 'date_retour_prevue', 'date_retour_effective'];
}
