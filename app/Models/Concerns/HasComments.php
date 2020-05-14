<?php

namespace App\Models\Concerns;

use App\Models\Comment;
use App\Models\User;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function comment(User $user, string $content)
    {
        return $this->comments()->create([
            'content' => $content,
            'user_id' => $user->id
        ]);
    }
}
