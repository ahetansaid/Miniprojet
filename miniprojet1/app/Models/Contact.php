<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['user_id', 'nom', 'prenom', 'telephone', 'email', 'categorie'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}