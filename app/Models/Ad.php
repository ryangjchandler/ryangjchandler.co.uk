<?php

namespace App\Models;

use App\Models\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    use AdPresenter;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date'
    ];
}
