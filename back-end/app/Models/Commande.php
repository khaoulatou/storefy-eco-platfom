<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'destinataire',
        'phone1',
        'phone2',
        'ville_customer',
        'addresse'


    ];
}
