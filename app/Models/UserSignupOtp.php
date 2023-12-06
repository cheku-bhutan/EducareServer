<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class UserSignupOtp extends Model
{
    protected $collection = 'user_signup_otps';

    protected $fillable = [
        'identifier',
        'token',
        'validity',
        'expired',
        'no_times_generated',
        'no_times_attempted',
        'generated_at'
    ];

    public function is_expired():bool
    {
        return (bool)$this->expired;
    }
    
}
