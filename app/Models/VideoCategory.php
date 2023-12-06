<?php

namespace App\Models;

use App\Models\Video;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoCategory extends Model
{
    use HasFactory;
    protected $collection = 'video_categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
    
}
