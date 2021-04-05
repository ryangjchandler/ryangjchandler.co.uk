<?php

namespace App\Models;

use Illuminate\Support\Str;
use Orbit\Concerns\Orbital;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Byte extends Model
{
    use Orbital;

    public static function schema(Blueprint $table)
    {
        $table->string('title');
        $table->string('slug');
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
        static::creating(function (Byte $byte) {
            if (! $byte->slug) {
                $byte->slug = Str::slug($byte->title);
            }
        });

        static::updating(function (Byte $byte) {
            $byte->slug = Str::slug($byte->title);

            Cache::forget('byte-content-'.$byte->slug);
        });
    }
}
