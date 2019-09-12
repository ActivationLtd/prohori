<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDistanceAndDistanceFlagsInUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uploads', function (Blueprint $table) {
            //
            $table->double('distance')->nullable()->default(null)->after('longitude');
            $table->integer('distance_flag_id')->nullable()->default(null)->after('distance');
            $table->string('distance_flag_name',100)->nullable()->default(null)->after('distance_flag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('upload', function (Blueprint $table) {
            //
        });
    }
}
