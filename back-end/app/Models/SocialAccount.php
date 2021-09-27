<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = ['provider', 'provider_user_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
