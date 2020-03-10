<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\UpdateAssignedForDaysInAssignment',
        'App\Console\Commands\SendOverDueTaskNotificationToAssigneeAndWatcher',
        'App\Console\Commands\SendDailyStatusEmail',
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // $schedule->command('inspire')
        //          ->hourly();
        //updating assigned for days
        $schedule->command('command:update-assigned-for-days-in-assignment')
            ->daily()
            ->appendOutputTo(public_path('files\schedular_log.txt'))
            ->emailOutputOnFailure('sanjidhabib@gmail.com');

        //sending daily status email
        $schedule->command('command:send-daily-status-email')
            ->daily()
            ->appendOutputTo(public_path('files\schedular_log.txt'))
            ->emailOutputOnFailure('sanjidhabib@gmail.com');

        //sending notification for tasks
        $schedule->command('command:over-due-notification-for-tasks')
            ->hourlyAt(30)
            ->timezone('Asia/Dhaka')
            ->between('9:00', '18:00')
            ->appendOutputTo(public_path('files\schedular_log.txt'))
            ->emailOutputOnFailure('sanjidhabib@gmail.com');
        //cache clear for application
        $schedule->command('cache:clear')
            ->twiceDaily(9, 14)
            ->timezone('Asia/Dhaka')
            ->appendOutputTo(public_path('files\schedular_log.txt'))
            ->emailOutputOnFailure('sanjidhabib@gmail.com');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
