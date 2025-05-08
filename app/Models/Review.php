<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function album() {
        return $this->belongsTo(Album::class);
    }

    public function comments() {
        return $this->hasMany(ReviewComment::class);
    }

}
