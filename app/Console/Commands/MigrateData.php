<?php

namespace App\Console\Commands;

use App\Http\Controllers\TableMigrationController;
use Illuminate\Console\Command;

class MigrateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:migrate-data {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from old LetsBab table to laravel-iso db';

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
        $table = $this->argument('table');
        $migration = New TableMigrationController();
        if ($table == 'partnercategories') {
            $migration->migratePartnercategories();
        } else if ($table == 'partners') {
            $migration->migratePartners();
        } else if ($table == 'charities') {
            $migration->migrateCharities();
        } else if ($table == 'users') {
            $migration->migrateUsers();
        } else if ($table == 'recommendurls') {
            $migration->migrateRecommendurls();
        } else if ($table == 'beacons') {
            $migration->migrateBeacons();
        } else if ($table == 'conversionrates') {
            $migration->migrateConversionrates();
        } else if ($table == 'purchases') {
            $migration->migratePurchases();
        } else if ($table == 'charityselections') {
            $migration->migrateCharityselections();
        } else if ($table == 'pushnotifications') {
            $migration->migratePushnotifications();
        } else if ($table == 'all') {
            $migration->migratePartnercategories();
            $migration->migratePartners();
            $migration->migrateCharities();
            $migration->migrateUsers();
            $migration->migrateRecommendurls();
            //$migration->migrateBeacons();
            $migration->migrateConversionrates();
            $migration->migratePurchases();
            $migration->migrateCharityselections();
            $migration->migratePushnotifications();
        }
    }
}
