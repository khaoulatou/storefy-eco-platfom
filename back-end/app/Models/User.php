<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname', 'surname', 'mobile_number', 'email', 'password', 'phone', 'country', 'subdomain',
        'storename', 'company_name', 'store_logo', 'company_address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Send a password reset notification to the user.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = 'http://localhost:8080/reset?token=' . $token;
        $this->notify(new ResetPasswordNotification($url));
    }

//    public function socialAccounts()
//    {
//        return $this->hasMany(SocialAccount::class);
//    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyNotification());
    }
}
