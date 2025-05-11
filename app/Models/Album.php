<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_date', 'cover_image', 'description', 'type'];

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
