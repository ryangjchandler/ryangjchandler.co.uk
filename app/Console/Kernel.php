<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\GenerateSitemap::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(Commands\GenerateSitemap::class)->dailyAt('22:00');
    }
}
