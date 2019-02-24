<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatusupdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statusupdates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 64)->nullable()->default(null);
            //$table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);

            /******* Custom columns **********/
            $table->string('type', 255)->nullable()->default(null);
            $table->text('note')->nullable()->default(null);

            $table->unsignedInteger('module_id')->nullable()->default(null);
            $table->unsignedInteger('element_id')->nullable()->default(null);
            $table->string('element_uuid', 64)->nullable()->default(null);

            $table->string('status', 255)->nullable()->default(null);

            $table->unsignedInteger('previous_id')->nullable()->default(null);
            $table->string('previous_status', 255)->nullable()->default(null);

            $table->unsignedInteger('next_id')->nullable()->default(null);
            $table->string('next_status', 255)->nullable()->default(null);

            $table->unsignedInteger('diff_secs')->nullable()->default(null);
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

        $name = 'statusupdates';
        if (\App\Module::where('name', $name)->doesntExist()) {
            \App\Module::create([
                'name' => $name,
                'title' => 'Status update',
                'description' => 'Manage status updates',
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
        Schema::dropIfExists('statusupdates');
    }
}
