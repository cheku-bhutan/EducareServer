<?php
namespace App\Models;

use App\Models\VideoCategory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    protected $collection = 'videos';

    protected $fillable = [
        'title',
        'subtitle',
        'release_date',
        'cover_photo',
        'video_url',
        'thumbnail',
        'status',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(VideoCategory::class, 'category_id', 'id');
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }
    
}