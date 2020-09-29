<?php

namespace App\Support\Markdown;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;

final class MarkdownServiceProvider extends ServiceProvider implements DeferrableProvider
{
    private $languages = [
        'html', 'css', 'javascript', 'php', 'bash', 'blade', 'yaml', 'yml',
    ];

    public function register()
    {
        $this->app->singleton(CommonMarkConverter::class, function () {
            $env = Environment::createCommonMarkEnvironment()
                ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($this->languages))
                ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($this->languages));

            return new CommonMarkConverter([], $env);
        });
    }

    public function provides()
    {
        return [
            CommonMarkConverter::class,
        ];
    }
}
