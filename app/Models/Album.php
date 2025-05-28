<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $casts = [
        'release_date' => 'date',
    ];

    protected $fillable = ['title', 'artist_id', 'release_date', 'cover_image', 'description', 'type'];


    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'album_genre');
    }


    public function review()
    {
        return $this->hasMany(Review::class);
    }


    public function lists()
    {
        return $this->belongsToMany(ListModel::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

}
