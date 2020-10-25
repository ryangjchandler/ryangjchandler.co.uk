<?php

namespace App\Models;

use App\Support\Newsletter\SubjectFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function list()
    {
        return $this->belongsTo(NewsletterList::class, 'newsletter_list_id');
    }

    public function getSubjectAttribute($subject = null)
    {
        if ($subject) {
            return SubjectFormatter::format($subject, $this);
        }

        if ($this->list) {
            return SubjectFormatter::format($this->list->subject, $this);
        }

        return null;
    }

    public function getEditionAttribute()
    {
        return $this->list->newsletters
            ->filter(fn (Newsletter $newsletter) => $newsletter->is($this))
            ->keys()
            ->first() + 1;
    }
}
