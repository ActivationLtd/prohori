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
    Route::get('client-location-ajax',['as'=>'custom.client-location','uses'=>'ClientlocationsController@customClientLocation']);
    Route::get('watcher-list-ajax',['as'=>'custom.watcher-list','uses'=>'UsersController@customWatcher']);
});

Route::get('test', 'MiscController@test')->name('misc.test');







