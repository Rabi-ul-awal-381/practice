<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'video_url',
        'category_id',
        'access_level',
        'views',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function videoViews()
    {
        return $this->hasMany(VideoView::class);
    }

    public function isPaid(): bool
    {
        return $this->access_level === 'paid';
    }
}