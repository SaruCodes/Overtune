<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public function list()
    {
        return $this->belongsTo(ListModel::class, 'list_model_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
