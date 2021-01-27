<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\PublishScheduledPosts::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Commands\PublishScheduledPosts::class)->hourly();
    }
}
