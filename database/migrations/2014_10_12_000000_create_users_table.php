<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 64)->nullable()->default(null);
            $table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);

            /*********************************/
            /*  Custom columns
            /*********************************/
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->rememberToken();

            // Email confirmation fields
            $table->string('email_verification_code', 128)->nullable(); // Not needed for signed temporary link
            $table->dateTime('email_verified_at')->nullable()->default(null);

            // Access token
            $table->string('access_token', 256)->nullable()->default(null);
            $table->dateTime('access_token_generated_at')->nullable()->default(null);

            // API token
            $table->string('api_token', 256)->nullable()->default(null);
            $table->dateTime('api_token_generated_at')->nullable()->default(null);
            $table->string('auth_token', 255)->nullable()->default(null); // Bearer token
            $table->string('session_secret', 255)->nullable()->default(null);

            // Can tenant edit a row?
            $table->tinyInteger('tenant_editable')->default(1);

            // Permission and user group
            $table->string('permissions', 2056)->nullable()->default(null);
            $table->string('group_ids_csv', 256)->nullable()->default(null); // 1,2,3
            $table->string('group_titles_csv', 1024)->nullable()->default(null); // Super admin, Tenant admin
            $table->string('name_initial', 10)->nullable()->default(null);
            $table->string('first_name', 128)->nullable()->default(null);
            $table->string('last_name', 128)->nullable()->default(null);
            $table->string('full_name', 256)->nullable()->default(null);
            $table->string('gender', 32)->nullable()->default(null);
            $table->string('profile_pic_url', 512)->nullable()->default(null);
            $table->string('currency', 36)->nullable()->default(null);

            /**
             * App usages
             */
            $table->string('device_token', 255)->nullable()->default(null);

            /**
             * Address
             * address1
             * address2
             * city
             * county
             * zip_code
             * country_id
             * country_name
             * phone
             * mobile
             */

            $table->string('address1', 512)->nullable()->default(null);
            $table->string('address2', 512)->nullable()->default(null);
            $table->string('city', 64)->nullable()->default(null);
            $table->string('county', 64)->nullable()->default(null);
            $table->unsignedInteger('country_id')->nullable()->default(null);
            $table->string('country_name', 100)->nullable()->default(null);
            $table->string('zip_code', 20)->nullable()->default(null);
            $table->string('phone', 20)->nullable()->default(null);
            $table->string('mobile', 20)->nullable()->default(null);

            /**
             * Activity
             */
            $table->dateTime('first_login_at')->nullable()->default(null);
            $table->dateTime('last_login_at')->nullable()->default(null);
            $table->string('social_account_id', 128)->nullable();
            $table->string('social_account_type', 128)->nullable();
            /*********************************/
            $table->tinyInteger('is_active')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
