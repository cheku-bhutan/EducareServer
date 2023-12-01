<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuperUser extends Model
{
    use HasFactory;
    public function role():BelongsTo 
    {
        return $this->belongsTo(Role::class);
    }
}
