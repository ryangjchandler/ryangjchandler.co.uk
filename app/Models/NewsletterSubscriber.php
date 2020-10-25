<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    public function list()
    {
        return $this->belongsTo(NewsletterList::class);
    }

    public function scopeOptedIn(Builder $query): void
    {
        $query->where('double_opt_in', true);
    }
}
