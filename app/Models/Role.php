<?php

namespace App\Models;

use App\Models\SuperUser;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $collection = 'roles';

    protected $fillable = [
        'name',
    ];

    public function super_users(): HasMany
    {
        return $this->hasMany(SuperUser::class);
    }
    
}
