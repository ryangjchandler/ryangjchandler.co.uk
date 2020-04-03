<?php

namespace RyanChandler\Markdown;

use TightenCo\Jigsaw\Parsers\MarkdownParser;
use GitDown\GitDown;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\Link;
use RyanChandler\Markdown\Renderers\LinkRenderer;
use TightenCo\Jigsaw\Parsers\JigsawMarkdownParser;

class Parser extends MarkdownParser
{
    protected $commonmark;

    protected static $languages = [
        'html', 'php', 'js', 'css', 'yaml', 'bash', 'json'
    ];

    public function __construct(JigsawMarkdownParser $parser = null)
    {
        parent::__construct();

        $this->commonmark = static::createCommonmark();
    }

    public function parse($markdown)
    {
        return $this->commonmark->convertToHtml($markdown);
    }

    protected static function createCommonmark()
    {
        $environment = Environment::createCommonMarkEnvironment()
            ->addInlineRenderer(Link::class, new LinkRenderer)
            ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer(static::$languages))
            ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer(static::$languages));

        return new CommonMarkConverter([], $environment);
    }
}