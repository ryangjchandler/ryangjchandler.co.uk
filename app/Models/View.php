<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $connection = 'analytics';

    public function viewable()
    {
        return $this->morphTo();
    }
}
