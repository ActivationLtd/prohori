<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 64)->nullable()->default(null);
            //$table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 1000)->nullable()->default(null);

            /******* Custom columns **********/
            $table->unsignedInteger('parent_id')->nullable()->default(null);
            $table->unsignedSmallInteger('priority')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);

            $table->unsignedInteger('tasktype_id')->nullable()->default(null);
            $table->string('tasktype_name', 255)->nullable()->default(null);

            $table->unsignedInteger('assignment_id')->nullable()->default(null);
            $table->unsignedInteger('assigned_to')->nullable()->default(null);
            $table->text('watchers')->nullable()->default(null);

            $table->string('status', 255)->nullable()->default(null);
            $table->string('previous_status', 255)->nullable()->default(null);
            $table->date('due_date')->nullable()->default(null);
            $table->date('days_open')->nullable()->default(null);

            $table->tinyInteger('is_closed')->nullable()->default(null);
            $table->unsignedInteger('closed_by')->nullable()->default(null);
            $table->text('closing_note')->nullable()->default(null);

            $table->tinyInteger('is_resolved')->nullable()->default(null);
            $table->unsignedInteger('resolved_by')->nullable()->default(null);
            $table->text('resolve_note')->nullable()->default(null);

            $table->tinyInteger('is_verified')->nullable()->default(null);
            $table->unsignedInteger('verified_by')->nullable()->default(null);
            $table->text('verify_note')->nullable()->default(null);

            $table->tinyInteger('is_flagged')->nullable()->default(null);
            $table->unsignedInteger('flagged_by')->nullable()->default(null);
            $table->text('flag_note')->nullable()->default(null);

            $table->text('tags')->nullable()->default(null);

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

        $name = 'tasks';
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
        Schema::dropIfExists('tasks');
    }
}
