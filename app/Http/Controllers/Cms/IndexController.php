<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('cms.index');
    }
}
