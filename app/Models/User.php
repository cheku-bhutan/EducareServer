<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use MongoDB\Laravel\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $collection = 'users';
    protected $fillable = [
        'user_id',
        'email',
        'password',
        'mobile_no',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_no_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    } 



}
