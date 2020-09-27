<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDistanceClientIdInUserLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('userlocations', function (Blueprint $table) {
            //
            $table->integer('client_id')->nullable()->default(null)->after('data');
            $table->string('client_name',255)->nullable()->default(null)->after('client_id');
            $table->integer('clientlocation_id')->nullable()->default(null)->after('client_name');
            $table->string('clientlocation_name',255)->nullable()->default(null)->after('clientlocation_id');
            $table->integer('clientlocationtype_id')->nullable()->default(null)->after('clientlocation_name');
            $table->string('clientlocationtype_name',255)->nullable()->default(null)->after('clientlocationtype_id');
            $table->double('clientlocation_longitude')->nullable()->default(null)->after('clientlocation_name');
            $table->double('clientlocation_latitude')->nullable()->default(null)->after('clientlocation_longitude');
            $table->double('distance')->nullable()->default(null)->after('clientlocation_latitude');
            $table->string('distance_flag', 100)->nullable()->default(null)->after('distance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userlocations', function (Blueprint $table) {
            //
            $table->dropColumn(['client_id','client_name','clientlocation_id','clientlocation_name','clientlocationtype_id','clientlocationtype_name','clientlocation_longitude','clientlocation_latitude', 'distance', 'distance_flag']);
        });
    }
}
