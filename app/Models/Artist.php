<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    public function albums() {
        return $this->belongsToMany(Album::class, 'album_artist');
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'favorite_artists');
    }

}
