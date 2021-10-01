<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $fillable = [
        'quantite',
        'ip',
        'produit_id',
    ];
    use HasFactory;
}
