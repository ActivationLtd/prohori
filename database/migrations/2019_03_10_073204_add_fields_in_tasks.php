<?php

// use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldsInTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedInteger('client_id')->nullable()->default(null)->after('seq');
            $table->string('client_name', 255)->nullable()->default(null)->after('client_id');

            $table->unsignedInteger('clientlocation_id')->nullable()->default(null)->after('client_name');
            $table->string('clientlocation_name', 255)->nullable()->default(null)->after('clientlocation_id');

            $table->unsignedInteger('clientlocationtype_id')->nullable()->default(null)->after('clientlocation_name');
            $table->string('clientlocationtype_name', 255)->nullable()->default(null)->after('clientlocationtype_id');

            $table->unsignedInteger('division_id')->nullable()->default(null)->after('clientlocationtype_name');
            $table->string('division_name', 255)->nullable()->default(null)->after('division_id');

            $table->unsignedInteger('district_id')->nullable()->default(null)->after('division_name');
            $table->string('district_name', 255)->nullable()->default(null)->after('district_id');

            $table->unsignedInteger('upazila_id')->nullable()->default(null)->after('district_name');
            $table->string('upazila_name', 255)->nullable()->default(null)->after('upazila_id');
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
