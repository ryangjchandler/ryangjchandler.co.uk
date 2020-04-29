<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\Cache;

class CategoriesController
{
    public function index()
    {
        return view('categories.index', [
            'categories' => Cache::rememberForever('all_categories', function () {
                return Category::all();
            }),
        ]);
    }

    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category,
        ]);
    }
}
