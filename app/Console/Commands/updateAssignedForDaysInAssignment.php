<?php

namespace App\Console\Commands;

use App\Assignment;
use Illuminate\Console\Command;

class updateAssignedForDaysInAssignment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateAssignedForDaysInAssignment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update assigned for days in existing assignment.';

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
        $assignments=Assignment::where('is_active',1)->whereNull('is_closed')->get();
        foreach($assignments as $assignment){
            $assignment->update(['assigned_for_days'=>$assignment->assigned_for_days+1]);
        }

    }
}
