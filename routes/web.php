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

use Illuminate\Support\Str;

Auth::routes(['verify' => true]);

// Route::get('register-partner', 'Auth\RegisterPartnerController@showRegistrationForm')->name('register.partner');
// Route::post('register-partner', 'Auth\RegisterPartnerController@register')->name('post.partner-registration');

Route::get('/', 'HomeController@index')->name('home')->middleware(['verified']);

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

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
$modules      = dbTableExists('modules') ? \App\Module::names() : []; // dbTableExists() was causing issue.
$modulegroups = dbTableExists('modulegroups') ? \App\Modulegroup::names() : [];

Route::middleware(['auth'])->group(function () use ($modules, $modulegroups) {
    Route::get('change-password', 'UsersController@showChangePasswordForm')->name('get.change-password');
    Route::get('logout', 'Auth\LoginController@logout')->name('get.logout');
    # default routes for all modules
    foreach ($modules as $module) {
        $Controller = ucfirst($module)."Controller";
        Route:: get($module."/{".Str::singular($module)."}/restore", $Controller."@restore")->name($module.'.restore');
        Route:: get($module."/grid", $Controller."@grid")->name($module.'.grid');
        Route:: get($module."/list/json", $Controller."@list")->name($module.'.list-json');
        Route:: get($module."/report", $Controller."@report")->name($module.'.report');
        Route:: get($module."/{".Str::singular($module)."}/changes", $Controller."@changes")->name($module.'.changes');
        Route::resource($module, $Controller);
    }

    # default routes for all modulegroups
    foreach ($modulegroups as $modulegroup) {
        Route::get($modulegroup, 'ModulegroupsController@modulegroupIndex')->name($modulegroup.'.index');
    }

    # route for updating an existing upload file
    Route::post('update_upload', 'UploadsController@updateExistingUpload')->name('uploads.update_last_upload');
    Route::get('download/{uuid}', 'UploadsController@download')->name('get.download');

    #Route for updating sequence in subtasks
    Route::post('subtasks/save-sequence', ['as' => 'subtasks.save-sequence', 'uses' => 'TasksController@postSaveSequence']);
    #route for custom list
    Route::get('user-client-list-ajax',['as'=>'custom.user-client-list','uses'=>'UsersController@customClientList']);
    Route::get('user-client-location-list-ajax',['as'=>'custom.user-client-location-list','uses'=>'UsersController@customClientLocationList']);
    Route::post('guard-location-filter',['as'=>'custom.guard-location-filter','uses'=>'UserlocationsController@guardLocationFilter']);
    Route::get('district-based-on-division',['as'=>'custom.district-based-on-division','uses'=>'DivisionsController@districtBasedOnDivision']);
    Route::get('upazila-based-on-district',['as'=>'custom.upazila-based-on-district','uses'=>'DivisionsController@upazilaBasedOnDistrict']);
    Route::get('clientloacation-based-on-client',['as'=>'custom.clientloacation-based-on-client','uses'=>'ClientsController@clientloacationBasedOnClient']);
});

Route::get('test', 'MiscController@test')->name('misc.test');
Route::get('privacy-policy', 'MiscController@privacypolicy')->name('misc.privacypolicy');
Route::get('dailyStatusEmail', 'MiscController@dailyStatusEmail')->name('misc.dailyStatus');
Route::get('notifiy-fcm', 'MiscController@notifyFcm')->name('misc.notifyfcm');
Route::get('notify-due-time', 'TasksController@sendNotificationsForTasksNotCompleted')->name('task.notifyduetime');







