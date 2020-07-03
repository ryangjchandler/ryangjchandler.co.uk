<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
