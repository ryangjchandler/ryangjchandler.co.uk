<?php

namespace App\Models;

use App\Models\Presenters\AdPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ad extends Model
{
    use HasFactory;
    use AdPresenter;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date'
    ];

    public static function booted()
    {
        static::saving(function (Ad $ad) {
            Cache::forget("ad_content_cache_{$ad->id}");
        });
    }
}
