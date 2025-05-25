<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function news()
    {
        return $this->hasMany(News::class);
    }
    public function getLatestNewsAttribute()
    {
        return $this->news()->latest()->take(3)->get();
    }
}
