<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('register-partner', 'Auth\RegisterPartnerController@showRegistrationForm')->name('register.partner');
Route::post('register-partner', 'Auth\RegisterPartnerController@register')->name('post.partner-registration');

Route::get('/', 'HomeController@index')->name('home')->middleware(['verified']);

/*
 *
 * Isotone Resources / RESTful routes.
 * ***************************************************************************
 * Resources automatically generates index, create, store, show, edit, update,
 * destroy routes. Based on the modules table all these routes are created.
 * In addition to above we also need a 'restore' as we have soft delete
 * enabled for our solution.
 *
 * prefix    :
 * filter    : before [auth] - only authenticated users can access these routes
 *        : before [resource.route.permission.check] - checks permission using Sentry.
 *****************************************************************************/
$modules = dbTableExists('modules') ? \App\Module::names() : []; // dbTableExists() was causing issue.
$modulegroups = dbTableExists('modulegroups') ? \App\Modulegroup::names() : [];

Route::middleware(['auth'])->group(function () use ($modules, $modulegroups) {
    Route::get('change-password', 'UsersController@showChangePasswordForm')->name('get.change-password');
    Route::get('logout', 'Auth\LoginController@logout')->name('get.logout');
    # default routes for all modules
    foreach ($modules as $module) {
        $Controller = ucfirst($module) . "Controller";
        Route:: get($module . "/{" . str_singular($module) . "}/restore", $Controller . "@restore")->name($module . '.restore');
        Route:: get($module . "/grid", $Controller . "@grid")->name($module . '.grid');
        Route:: get($module . "/list/json", $Controller . "@list")->name($module . '.list-json');
        Route:: get($module . "/report", $Controller . "@report")->name($module . '.report');
        Route:: get($module . "/{" . str_singular($module) . "}/changes", $Controller . "@changes")->name($module . '.changes');
        Route::resource($module, $Controller);
    }

    # default routes for all modulegroups
    foreach ($modulegroups as $modulegroup) {
        Route::get($modulegroup, 'ModulegroupsController@modulegroupIndex')->name($modulegroup . '.index');
    }

    # route for updating an existing upload file
    Route::post('update_upload', 'UploadsController@updateExistingUpload')->name('uploads.update_last_upload');

    # Individual/Current partner routes
    Route::get('partner/edit', 'PartnersController@editMyPartner')->name('get.edit-my-partner');
    Route::get('users/{user}/invoices', 'UsersController@invoices')->name('get.users-invoices');

    # Show charity invoices.
    Route::get('charities/{charity}/invoices', 'CharitiesController@invoices')->name('get.charities-invoices');
    Route::get('users/{user}/invoices', 'UsersController@invoices')->name('get.users-invoices');

    /**
     * Generate download request of a file.
     * Files are stored in a physical file system. To hide the urls from the user following URL generates a download
     * request that initiates download of the file matching the uuid.
     */
    Route::get('download/{uuid}', 'UploadsController@download')->name('get.download');
    /**
     * Data migration routes
     */
    // Route::get('migrate/partnercategories', 'TableMigrationController@migratePartnercategories')->name('migrate.partnercategories');
    //Route::get('migrate/partners', 'TableMigrationController@migratePartners')->name('migrate.partners');
    // Route::get('migrate/charities', 'TableMigrationController@migrateCharities')->name('migrate.charities');
    Route::get('migrate/users', 'TableMigrationController@migrateUsers')->name('migrate.users');
    // Route::get('migrate/recommendurls/{start}', 'TableMigrationController@migrateRecommendUrls')->name('migrate.recommendurls');
    // Route::get('migrate/beacons', 'TableMigrationController@migrateBeacons')->name('migrate.beacons');
    // Route::get('migrate/conversionrates', 'TableMigrationController@migrateConversionRates')->name('migrate.conversionrates');
    // Route::get('migrate/charityselections', 'TableMigrationController@migrateCharitySelections')->name('migrate.charityselections');
    // Route::get('migrate/pushnotifications', 'TableMigrationController@migratePushNotifications')->name('migrate.pushnotifications');
    // Route::get('migrate/purchases', 'TableMigrationController@migratePurchases')->name('migrate.purchases');
});

// Redirections
Route::get('u/{short_code}', 'RecommendurlsController@redirectU')->name('recommendurls.redirect-u');
Route::get('m/{short_code}', 'RecommendurlsController@redirectM')->name('recommendurls.redirect-m');

Route::get('link-expired', 'MiscController@showLinkExpiredUI')->name('misc.link-expired');
Route::get('test', 'MiscController@test')->name('misc.test');
Route::get('update-user-country', 'MiscController@updateUserCountry')->name('misc.update-user-country');





