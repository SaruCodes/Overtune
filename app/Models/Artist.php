<?php


// app/Models/Artist.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'image',
        'country',
        'debut',
    ];


    public function albums()
    {
        return $this->hasMany(Album::class);
    }

}



