<?php

namespace App\Console\Commands;

use App\Http\Controllers\MiscController;
use Illuminate\Console\Command;

class OptimizeUploadFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:optimize-upload-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will optimize all uploaded files in the system';

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
        MiscController::optimizeImages();
    }
}
