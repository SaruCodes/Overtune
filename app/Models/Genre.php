<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['genre'];

    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_genre');
    }
}

