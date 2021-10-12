<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        "nom",
        "active",
        "dateDebut",
        "dateFin",
        "nombre_utilisateur",
        "type_prix",
        "type_expiration",
        "remise",
        "subdomain"
    ];
}
