<?php

namespace App\Support\Markdown;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkProcessor;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
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
                ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($this->languages))
                ->addExtension(new HeadingPermalinkExtension)
                ->addExtension(new TableOfContentsExtension);

            return new CommonMarkConverter([
                'table_of_contents' => [
                    'html_class' => 'table-of-contents',
                    'position' => 'top',
                    'style' => 'bullet',
                    'min_heading_level' => 1,
                    'max_heading_level' => 6,
                    'normalize' => 'relative',
                    'placeholder' => null,
                ],
                'heading_permalink' => [
                    'symbol' => '#',
                    'insert' => HeadingPermalinkProcessor::INSERT_AFTER,
                    'title' => 'Permalink',
                ],
            ], $env);
        });
    }

    public function provides()
    {
        return [
            CommonMarkConverter::class,
        ];
    }
}
