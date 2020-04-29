<?php

namespace App\Services\Markdown;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\Link;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;

class MarkdownServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(CommonMarkConverter::class, function () {
            $environment = Environment::createCommonMarkEnvironment()
                ->addInlineRenderer(Link::class, new LinkRenderer)
                ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer(Markdown::$languages))
                ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer(Markdown::$languages));

            return new CommonMarkConverter([], $environment);
        });
    }

    public function provides()
    {
        return [CommonMarkConverter::class];
    }
}
