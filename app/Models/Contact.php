<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Étape magique : On autorise le remplissage de ces champs précis
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'telephone',
        'email',
        'categorie',
    ];

    // La relation inverse vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}