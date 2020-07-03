<?php

namespace App\Models\Presenters;

trait UserPresenter
{
    public function avatar()
    {
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        return url($this->avatar ?? '/img/default-avatar.jpg');
    }
}
