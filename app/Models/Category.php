<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function news()
    {
        return $this->hasMany(News::class);
    }
    public function latestNewsLimited()
    {
        return $this->hasMany(News::class)->latest()->take(5);
    }

    public function latestNews()
    {
        return $this->hasMany(News::class)->latest()->limit(5);
    }
}
