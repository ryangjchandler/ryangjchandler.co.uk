<?php

namespace RyanChandler\Console\Commands;

use TightenCo\Jigsaw\Console\Command;
use Illuminate\Contracts\Container\Container;

class FetchWebmentionsCommand extends Command
{
    /** @var \Illuminate\Contracts\Container\Container; */
    private $app;

    /** @var array */
    private $config;

    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->config = $this->app->config['webmentions'];

        parent::__construct();
    }

    protected function fire()
    {
        $since = now()->subDays(3);

        $url = $this->config['url'] .
            "?domain={$this->config['domain']}" .
            "&token={$this->config['token']}" .
            "&since={$since->toIso8601String()}" .
            "&per-page={$this->config['per_page']}";

        $response = json_decode(file_get_contents($url), true);

        if (! array_key_exists('children', $response)) {
            $this->console->error('Invalid response.');
            exit(1);
        }

        foreach ($response['children'] as &$webmention) {
            $webmention['wm-target'] = trim(str_replace(
                'https://' . $this->config['domain'] . '/', '', $webmention['wm-target']
            ), '/');

            $webmention['wm-target'] = preg_replace('/\/$/', '', $webmention['wm-target']);
            $webmention['wm-target'] = str_replace('/', '--', $webmention['wm-target']);

            $filename = __DIR__.'/../../../source/_webmentions/' . $webmention['wm-target'] . '.json';

            if (! file_exists($filename)) {
                touch($filename);

                file_put_contents($filename, json_encode([$webmention], JSON_PRETTY_PRINT));

                continue;
            }

            $entries = json_decode(file_get_contents($filename), true);

            $entries = array_filter($entries, function ($existingWebmention) use ($webmention) {
                return $existingWebmention['wm-id'] !== $webmention['wm-id'] || $existingWebmention['author']['name'] !== 'Ryan Chandler';
            });

            $entries[] = $webmention;

            $entries = array_filter($entries, function ($webmention) {
                return $webmention['author']['name'] !== 'Ryan Chandler';
            });
                
            usort($entries, function ($a, $b) {
                return $a['wm-id'] - $b['wm-id'];
            });

            file_put_contents($filename, json_encode($entries, JSON_PRETTY_PRINT));
        }
    }

    protected function configure()
    {
        $this->setName('fetch-webmentions')
            ->setDescription('Fetch webmentions for the site.');
    }
}
