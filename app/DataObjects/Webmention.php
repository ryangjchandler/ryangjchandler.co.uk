<?php

namespace RyanChandler\DataObjects;

use Carbon\Carbon;

class Webmention
{
    public string $content;

    public object $author;

    public string $keyword;

    public Carbon $date;

    public string $sourceUrl;

    public function __construct(array $webmention)
    {
        $this->content = $webmention['content']['html'] ?? $webmention['content']['text'] ?? '';
        $this->author = (object) $webmention['author'];
        $this->keyword = $this->determineKeywordFromType($webmention['wm-property']);
        $this->date = Carbon::parse($webmention['published']);
        $this->sourceUrl = $webmention['url'];
    }

    public function avatar()
    {
        return $this->author->photo;
    }
    
    protected function determineKeywordFromType(string $type): string
    {
        switch ($type) {
            case 'in-reply-to':
                return 'replied';
            case 'repost-of':
                return 'retweeted';
            case 'mention-of':
                return 'mentioned';
            default:
                return 'liked';
        }
    }
}