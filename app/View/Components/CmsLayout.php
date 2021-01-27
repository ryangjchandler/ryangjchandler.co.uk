<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CmsLayout extends Component
{
    public function user()
    {
        return optional(Auth::user());
    }

    public function render()
    {
        return view('layouts.cms');
    }
}
