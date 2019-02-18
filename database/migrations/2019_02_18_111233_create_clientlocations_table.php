<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientlocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientlocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 64)->nullable()->default(null);
            $table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);

            /******* Custom columns **********/
            //$table->string('title', 100)->nullable()->default(null);
            //$table->text('somecolumnsname')->nullable()->default(null);

            $table->unsignedInteger('division_id')->nullable()->default(null);
            $table->string('division_name', 50)->nullable()->default(null);
            $table->unsignedInteger('district_id')->nullable()->default(null);
            $table->string('district_name', 50)->nullable()->default(null);
            $table->unsignedInteger('upazila_id')->nullable()->default(null);
            $table->string('upazila_name', 50)->nullable()->default(null);
            $table->double('latitude')->nullable()->default(null);
            $table->double('longitude')->nullable()->default(null);

            $table->unsignedInteger('client_id')->nullable()->default(null);
            $table->string('client_name',255)->nullable()->default(null);
            $table->unsignedInteger('operatingarea_id')->nullable()->default(null);
            $table->string('operatingarea_name',255)->nullable()->default(null);
            $table->unsignedInteger('clientlocationtype_id')->nullable()->default(null);
            $table->string('clientlocationtype_name',255)->nullable()->default(null);

            /*********************************/

            $table->tinyInteger('is_active')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
        });

        $name = 'clientlocations';
        if (\App\Module::where('name', $name)->doesntExist()) {
            \App\Module::create([
                'name' => $name,
                'title' => ucfirst(str_singular($name)),
                'description' => 'Manage ' . str_singular($name),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientlocations');
    }
}
