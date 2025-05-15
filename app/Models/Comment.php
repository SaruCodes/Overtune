<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['contenido', 'user_id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

