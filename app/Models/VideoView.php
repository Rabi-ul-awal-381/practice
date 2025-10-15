<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    protected $fillable = ['user_id', 'video_id', 'viewed_at'];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}