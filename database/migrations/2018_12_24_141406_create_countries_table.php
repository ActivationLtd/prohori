<?php

// use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 64)->nullable()->default(null);
            //$table->unsignedInteger('tenant_id')->nullable()->default(null);
            $table->string('name', 255)->nullable()->default(null);

            /******* Custom columns **********/
            $table->string('code', 32)->nullable()->default(null);
            $table->string('country_id', 10)->nullable()->default(null);
            $table->string('iso2', 16)->nullable()->default(null);
            $table->string('country_short_name', 64)->nullable()->default(null);
            $table->string('country_long_name', 255)->nullable()->default(null);
            $table->string('iso3', 16)->nullable()->default(null);
            $table->string('numcode', 16)->nullable()->default(null);
            $table->string('un_member', 16)->nullable()->default(null);
            $table->string('calling_code', 16)->nullable()->default(null);
            $table->string('cctld', 16)->nullable()->default(null);
            $table->string('currency', 50)->nullable()->default(null);
            $table->string('currency_symbol', 10)->nullable()->default(null);
            $table->string('currency_override', 50)->nullable()->default(null);
            $table->string('currency_override_symbol', 50)->nullable()->default(null);
            //$table->text('somecolumnsname')->nullable()->default(null);
            /*********************************/

            $table->tinyInteger('is_active')->nullable()->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(null);
            $table->unsignedInteger('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('deleted_by')->nullable()->default(null);
        });

        $name = 'countries';
        if (\App\Module::where('name', $name)->doesntExist()) {
            \App\Module::create([
                'name' => $name,
                'title' => ucfirst(str_singular($name)),
                'description' => 'Manage ' . str_singular($name),
            ]);
        }

        // Fill Euro https://europa.eu/european-union/about-eu/countries_en
        DB::table('countries')->whereIn('id', \App\Country::euroCountryIds())->update([
            'currency' => 'EUR',
            'currency_symbol' => '€',
            'currency_override' => 'EUR',
            'currency_override_symbol' => '€'
        ]);

        // Fill US
        DB::table('countries')->where('id', 200)->update([
            'name' => 'US (United States)',
            'currency' => 'USD',
            'currency_symbol' => '$',
            'currency_override' => 'USD',
            'currency_override_symbol' => '$'
        ]);

        // Fill UK
        DB::table('countries')->where('id', 187)->update([
            'name' => 'UK (United Kingdom)',
            'currency' => 'GBP',
            'currency_symbol' => '£',
            'currency_override' => 'GBP',
            'currency_override_symbol' => '£'
        ]);

        // Fill Rest of the world
        DB::table('countries')->whereNull('currency')->update([
            'currency' => 'USD',
            'currency_symbol' => '$',
            'currency_override' => 'USD',
            'currency_override_symbol' => '$'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
