<?php

namespace App\Models;

use App\Models\Video;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoView extends Model
{
    use HasFactory;
    protected $collection = 'video_views';

    protected $fillable = [
        'duration_watched',
        'country',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
