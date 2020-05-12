<?php

namespace App\Services\Markdown;

use League\CommonMark\CommonMarkConverter;

final class Markdown
{
    private $commonmark;

    public function __construct(CommonMarkConverter $commonmark)
    {
        $this->commonmark = $commonmark;
    }

    public function parse(string $markdown)
    {
        return $this->commonmark->convertToHtml($markdown);
    }
}
