<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWatchersOperatingAreaIdInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('watchers')->nullable()->default(null)->after('department_name');
            $table->text('operating_area_ids')->nullable()->default(null)->after('watchers');
            $table->text('operating_area_names')->nullable()->default(null)->after('operating_area_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
