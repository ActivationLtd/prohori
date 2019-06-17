<?php

namespace App\Console\Commands;

use App\Mail\DailyStatus;
use Illuminate\Console\Command;
use App\Mail\TaskCreated;

class sendDailyStatusEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendDailyStatusEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send a email to SuperAdmins about the daily status of the application';

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
        \Mail::to('sanjidhabib@gmail.com')->send(
                new DailyStatus()
            );
    }
}
