<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function artists() {
        return $this->belongsToMany(Artist::class, 'album_artist');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'album_genre');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'favorite_albums');
    }

    public function lists() {
        return $this->belongsToMany(ListModel::class, 'list_album');
    }

}
