<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function latestNews()
    {
        return $this->hasMany(News::class)->latest();
    }
}
