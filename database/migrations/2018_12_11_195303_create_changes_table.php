<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 64)->nullable()->default(null);
            $table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);

            /******* Custom columns **********/
            $table->string('changeset', 32)->nullable()->default(null);
            $table->unsignedInteger('module_id')->nullable()->default(null);
            $table->string('module_name', 255)->nullable()->default(null);
            $table->unsignedBigInteger('element_id')->nullable()->default(null);
            $table->string('element_uuid', 64)->nullable()->default(null);
            $table->string('field', 124)->nullable()->default(null);
            $table->text('old')->nullable()->default(null);
            $table->text('new')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            /*********************************/

            $table->tinyInteger('is_active')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
        });

        $name = 'changes';
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
        Schema::dropIfExists('changes');
    }
}
