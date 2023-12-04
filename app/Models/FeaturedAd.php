<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeaturedAd extends Model
{
    use HasFactory;
    protected $collection = 'featured_ads';

    protected $fillable = [
        'title',
        'type',
        'cover_photo',
        'sub_title',
        'descritption',
        'status'
    ];
    
}