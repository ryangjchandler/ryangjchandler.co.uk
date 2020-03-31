<?php

namespace RyanChandler\Listeners;

use TightenCo\Jigsaw\Jigsaw;
use Abraham\TwitterOAuth\TwitterOAuth;

class TweetArticles
{
    protected $twitter;

    public function __construct()
    {
        $this->twitter = new TwitterOAuth(
            env('TWITTER_CONSUMER_KEY'),
            env('TWITTER_CONSUMER_SECRET'),
            env('TWITTER_ACCESS_TOKEN'),
            env('TWITTER_ACCESS_TOKEN_SECRET')
        );
    }

    public function handle(Jigsaw $jigsaw)
    {
        $posts = $jigsaw->getCollection('posts')
            ->filter(function ($post) {
                return $post->should_tweet && ! ($post->tweeted ?? true);
            })
            ->each(function ($post) {
                if ($post->tweeted) {
                    return;
                }

                $message = sprintf(
                    "🔥 NEW ARTICLE - %s - %s",
                    $post->title,
                    $post->getUrl()
                );

                $response = $this->tweet($message);

                $tweetUrl = "https://twitter.com/ryangjchandler/status/{$response['id_str']}";

                $originalContents = file_get_contents($filePath = ($post->_meta->source . '/' . $post->getFilename() . '.md'));
                
                $newContents = str_replace('should_tweet: true', 'should_tweet: false', $originalContents);
                $newContents = str_replace('tweeted: false', 'tweeted: true', $newContents);
                $newContents = str_replace('tweet_link:', 'tweet_link: ' . $tweetUrl, $newContents);

                file_put_contents($filePath, $newContents);
            });
    }

    protected function tweet(string $status)
    {
        return (array) $this->twitter->post('statuses/update', compact('status'));
    }
}