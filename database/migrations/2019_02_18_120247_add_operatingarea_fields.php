<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

class AddOperatingareaFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->unsignedBigInteger('operatingarea_id')->nullable()->default(null)->after('code');
            $table->string('operatingarea_name', 255)->nullable()->default(null)->after('operatingarea_id');
        });

        Schema::table('districts', function (Blueprint $table) {
            $table->unsignedBigInteger('operatingarea_id')->nullable()->default(null)->after('division_name');
            $table->string('operatingarea_name', 255)->nullable()->default(null)->after('operatingarea_id');
        });

        Schema::table('upazilas', function (Blueprint $table) {
            $table->unsignedBigInteger('operatingarea_id')->nullable()->default(null)->after('district_name');
            $table->string('operatingarea_name', 255)->nullable()->default(null)->after('operatingarea_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
