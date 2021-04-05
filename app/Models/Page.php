<?php

namespace App\Models;

use Illuminate\Support\Str;
use Orbit\Concerns\Orbital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    use Orbital;

    public $timestamps = false;

    public static function schema(Blueprint $table)
    {
        $table->string('title');
        $table->string('slug');
        $table->text('content')->nullable();
    }

    public function getKeyName()
    {
        return 'slug';
    }

    public function getIncrementing()
    {
        return false;
    }

    public static function booted()
    {
        static::creating(function (Page $page) {
            $page->slug = Str::slug($page->title);
        });

        static::updating(function (Page $page) {
            $page->slug = Str::slug($page->title);

            Cache::forget('page-content-'.$page->slug);
        });
    }
}
