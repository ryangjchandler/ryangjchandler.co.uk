<?php

namespace App\Models;

use Illuminate\Support\Str;
use Orbit\Concerns\Orbital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Category extends Model
{
    use Orbital;

    public static function schema(Blueprint $table)
    {
        $table->string('title');
        $table->string('slug');
        $table->string('color')->default('gray');
    }

    public function url()
    {
        return route('posts.index', [
            'category' => $this->slug,
        ]);
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
        static::creating(function (Category $category) {
            if (! $category->slug) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function (Category $category) {
            if (! $category->published) {
                $category->slug = Str::slug($category->title);
            }
        });
    }
}
