<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatitudeLongitudeInTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->double('latitude')->nullable()->default(null)->after('upazila_name');
            $table->double('longitude')->nullable()->default(null)->after('latitude');
            $table->text('client_obj')->nullable()->default(null)->after('client_name');
            $table->text('clientlocation_obj')->nullable()->default(null)->after('clientlocation_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
}
