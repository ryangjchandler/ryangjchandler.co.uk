<?php

namespace RyanChandler\Markdown;

use TightenCo\Jigsaw\Parsers\MarkdownParser;
use GitDown\GitDown;

class Parser extends MarkdownParser
{
    public function parse($markdown)
    {
        return (new GitDown)->parse($markdown);
    }
}