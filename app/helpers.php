<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;

function markdown(string $markdown, string $cacheKey = null) {
    $environment = Environment::createGFMEnvironment();
    $environment->addBlockRenderer(FencedCode::class, new FencedCodeRenderer());
    $environment->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer());

    $environment->addExtension(new ExternalLinkExtension);

    $converter = new GithubFlavoredMarkdownConverter([
        'external_link' => [
            'internal_hosts' => config('app.url'),
            'open_in_new_window' => true,
            'noopener' => 'external',
            'noreferrer' => 'external',
        ]
    ], $environment);

    if ($cacheKey && app()->environment('production')) {
        return Cache::rememberForever($cacheKey, fn () => $converter->convertToHtml($markdown));
    }

    return $converter->convertToHtml($markdown);
}
