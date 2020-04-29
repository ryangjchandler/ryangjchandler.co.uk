<?php

namespace App\Services\Markdown;

use League\CommonMark\CommonMarkConverter;

final class Markdown
{
    private $commonmark;

    public static $languages = [
        'html', 'php', 'js', 'css', 'yaml', 'bash', 'json',
    ];

    public function __construct(CommonMarkConverter $commonmark)
    {
        $this->commonmark = $commonmark;
    }

    public function parse(string $markdown)
    {
        return $this->commonmark->convertToHtml($markdown);
    }
}
