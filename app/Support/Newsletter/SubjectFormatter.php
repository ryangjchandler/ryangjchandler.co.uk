<?php

namespace App\Support\Newsletter;

use App\Models\Newsletter;

class SubjectFormatter
{
    public static function format(string $subject, Newsletter $newsletter): string
    {
        $replace = [
            '[title]' => $newsletter->title,
            '[name]' => $newsletter->list->name,
            '[edition]' => '#' . $newsletter->edition,
        ];

        foreach ($replace as $target => $value) {
            $subject = str_replace($target, $value, $subject);
        }

        return $subject;
    }
}
