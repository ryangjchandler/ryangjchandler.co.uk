<?php

namespace RyanChandler\Listeners;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;
use TightenCo\Jigsaw\Jigsaw;

class GenerateFeed
{
    public function handle(Jigsaw $jigsaw)
    {
        $config = $jigsaw->getConfig();

        if (!$config['baseUrl']) {
            echo("\nTo generate a rss.xml file, please specify a 'baseUrl' in config.php.\n\n");
            return;
        }

        $feed = new Feed();

        $channel = new Channel();
        $channel
            ->title($config['title'])
            ->description($config['description'])
            ->url($config['baseUrl'])
            ->feedUrl(rtrim($config['baseUrl'], '/') . '/feed.xml')
            ->language('en-GB')
            ->copyright('Copyright © '. $config['title'] . ' ' . (new \DateTime())->format('Y'))
            ->pubDate((new \DateTime())->getTimestamp())
            ->lastBuildDate((new \DateTime())->getTimestamp())
            ->appendTo($feed);

        $jigsaw->getCollection('posts')->each(function ($post) use ($channel, $config) {
            // Blog item
            $item = new Item();
            $item
                ->title($post->title)
                // ->description($post->excerpt)
                ->contentEncoded($post)
                ->url($post->getUrl())
                ->author($config['author'])
                ->pubDate((new \DateTime('@'.$post->date))->getTimestamp())
                ->guid($post->getUrl(), true)
                ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
                ->appendTo($channel);
        });

        $jigsaw->writeOutputFile('feed.xml', $feed->render());
    }
}