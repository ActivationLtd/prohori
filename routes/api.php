<?php

use Illuminate\Http\Request;

$modules      = dbTableExists('modules') ? \App\Module::names() : []; // dbTableExists() was causing issue.
$modulegroups = dbTableExists('modulegroups') ? \App\Modulegroup::names() : [];

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('1.0')->middleware(['ret.json'])->group(function () use ($modules, $modulegroups) {
    Route::middleware(['x-auth-token'])->group(function () use ($modules, $modulegroups) {
        #  Common GET API for all existing modules
        // Automatically API end-points are created so that table rows can be fetched as JSON
        // This is a minimalistic approach to serve data. There can be other customized
        // APIs that are more appropriate for specific usage of data.
        Route::prefix('module')->group(function () use ($modules) {
            foreach ($modules as $module) {
                $Controller = ucfirst($module)."Controller";
                // generate the API route.
                Route:: get($module."/list", $Controller."@list")->name("api.{$module}.list");
                Route:: get($module."/report", $Controller."@report")->name("api.{$module}.report");
                Route::resource($module, $Controller); // for some reason this resource route needs be placed at the bottom otherwise it does work.
            }
        });
        // Settings api
        Route::get('setting/{name}', ['as' => 'api.get.setting', 'uses' => 'SettingsController@getSetting']);
        Route::post('register', 'Auth\RegisterController@register')->name('api.register');
        Route::post('login', 'Auth\LoginController@login')->name('api.login');
        Route::post('social-login', 'Auth\LoginController@socialLogin')->name('api.social-login');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('api.forgot-password');

        Route::middleware(['auth.bearer'])->group(function () use ($modules, $modulegroups) {
            Route::prefix('user')->group(function () {

                // Profile
                Route::get('profile', 'Api\UserApiController@getUserProfile')->name('api.user.profile');
                Route::get('logout', 'Auth\LoginController@logout')->name('api.user.logout');
                Route::post('uploads', 'Api\UserApiController@uploadsStore')->name('api.user.uploads-store');
                Route::patch('update', 'Api\UserApiController@usersPatch')->name('api.user.usersPatch');
                Route::delete('uploads/avatar', 'Api\UserApiController@uploadsDeleteAvatar')->name('api.user.uploads-delete-avatar');

                // Summary
                Route::get('summary', 'Api\UserApiController@summary')->name('api.user.summary');

                // Tasks
                Route::get('tasks', 'Api\UserApiController@tasks')->name('api.user.tasks');
                Route::post('tasks/create', 'Api\UserApiController@tasksCreate')->name('api.user.tasks.create');
                Route::patch('tasks/{id}/update', 'Api\UserApiController@tasksUpdate')->name('api.user.tasks.update');
                Route::post('tasks/{id}/upload', 'Api\UserApiController@tasksUpload')->name('api.user.tasks.upload');
                Route::get('tasks/{id}/getUploads', 'Api\UserApiController@getUploads')->name('api.user.tasks.uploads');
                Route::get('tasks/{id}/getSubtasks', 'Api\UserApiController@getSubtasks')->name('api.user.tasks.subtasks');
                Route::get('tasks/{id}/getAssignments', 'Api\UserApiController@getAssignments')->name('api.user.tasks.assignments');


            });
        });

    });

});

//  Public APIs coming from different sources
Route::group(['prefix' => 'public'], function () {

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization, X-CSRF-Token','X-Auth-Token");

    Route::post('catch', 'Api\PublicApiController@catch')->name('api.public.catch');
    Route::post('beacons', 'Api\PublicApiController@beaconsStore')->name('api.public.beacons-store');
    Route::post('apiresponses', 'Api\PublicApiController@apiresponsesStore')->name('api.public.apiresponses-store');
    Route::get('user-name/{share_code}', 'Api\PublicApiController@getUserNameFromShareCode')->name('api.public.get-user-name-from-share-code');
});