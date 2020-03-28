<?php

namespace RyanChandler\Listeners;

use Highlight\Highlighter;
use TightenCo\Jigsaw\Jigsaw;

class HighlightCodeBlocks
{
    public function handle(Jigsaw $jigsaw)
    {
        $jigsaw->getCollection('posts')->each(function ($post) use ($jigsaw) {
            $fileName = ltrim($post->_meta->path[0] . '/index.html', '/');
            $content = $jigsaw->readOutputFile($fileName);
            $updatedContent = $this->applySyntaxHighlighting($content);
            $jigsaw->writeOutputFile($fileName, $updatedContent);
        });
    }

    /**
     * Apply Syntax Highlighting on a string
     * Adapted from https://github.com/S1SYPHOS/kirby-highlight/blob/master/core/syntax_highlight.php
     * @param  string $value
     * @return string
     */
    private function applySyntaxHighlighting(string $value) : string
    {
        $pattern = '~<pre><code[^>]*>\K.*(?=</code></pre>)~Uis';

        return preg_replace_callback($pattern, function ($match) {
            $highlighter = new Highlighter();
            $highlighter->setAutodetectLanguages([
                'html',
                'php',
                'css',
                'js',
                'shell'
            ]);
            $input = htmlspecialchars_decode($match[0]);

            return $highlighter->highlightAuto($input)->value;
        }, $value);
    }
}