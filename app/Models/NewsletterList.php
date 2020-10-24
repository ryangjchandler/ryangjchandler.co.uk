<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterList extends Model
{
    use HasFactory;

    public static function booted()
    {
        static::creating(function (NewsletterList $list) {
            $list->slug = Str::slug($list->name);
        });
    }

    public function subscribers()
    {
        return $this->hasMany(NewsletterSubscriber::class);
    }
}
