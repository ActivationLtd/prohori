<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientlocationtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientlocationtypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 64)->nullable()->default(null);
            $table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);

            /******* Custom columns **********/
            //$table->string('title', 100)->nullable()->default(null);
            //$table->text('somecolumnsname')->nullable()->default(null);
            /*********************************/

            $table->tinyInteger('is_active')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
        });

        $name = 'clientlocationtypes';
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
        Schema::dropIfExists('clientlocationtypes');
    }
}
