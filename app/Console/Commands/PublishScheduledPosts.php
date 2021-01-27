<?php

namespace App\Console\Commands;

use App\Models\Cms\Post;
use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
    protected $name = 'cms:publish-scheduled-posts';

    protected $description = 'Check for any posts that need to be published and publish them.';

    public function handle()
    {
        Post::query()
            ->where('status', '!=', 'published')
            ->whereNotNull('publish_at')
            ->get()
            ->each
            ->update([
                'status' => 'published',
                'publish_at' => null,
            ]);

        $this->info('Successfully published scheduled posts.');

        return 0;
    }
}
