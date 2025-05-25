<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'album_id',
        'rating',
        'content',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function album() {
        return $this->belongsTo(Album::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }


}
