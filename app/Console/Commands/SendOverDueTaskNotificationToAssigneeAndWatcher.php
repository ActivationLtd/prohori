<?php

namespace App\Console\Commands;

use App\Http\Controllers\TasksController;
use Illuminate\Console\Command;

class SendOverDueTaskNotificationToAssigneeAndWatcher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:over-due-notification-for-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will run daily for checking overdue tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        TasksController::sendNotificationsForTasksNotCompleted();
    }
}
