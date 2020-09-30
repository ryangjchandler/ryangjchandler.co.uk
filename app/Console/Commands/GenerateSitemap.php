<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $name = 'generate-sitemap';

    public function handle(SitemapGenerator $generator)
    {
        $generator->setUrl(
            config('app.url')
        )->writeToFile(
            public_path('sitemap.xml')
        );

        $this->info('Successfully generate sitemap.xml file.');
    }
}
