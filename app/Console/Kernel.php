<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:clean')->daily()->at('05:15');
        $schedule->command('backup:run')->daily()->at('05:30');

        // Scheduling newsletter campaign
        // Every Friday at 13h
        $schedule->command('newsletter:send')->weeklyOn(5, '13:00');

        // Scheduling newsletter synchronization
        // Every day at 02h
        $schedule->command('newsletter:sync')->dailyAt('02:00');

        // Re-import Scout data in Algolia
        $schedule->command('scout:reimport')->runInBackground()->cron('12 9,12,15,18 * * *');

        $schedule->call(function () {
            Log::info('Cron is working!');
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
