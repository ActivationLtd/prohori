<?php

use Illuminate\Http\Request;

$modules = dbTableExists('modules') ? \App\Module::names() : []; // dbTableExists() was causing issue.
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
                $Controller = ucfirst($module) . "Controller";
                // generate the API route.
                Route:: get($module . "/list", $Controller . "@list")->name("api.{$module}.list");
                Route:: get($module . "/report", $Controller . "@report")->name("api.{$module}.report");
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

                // Profile + logout
                Route::get('tasks', 'Api\UserApiController@tasks')->name('api.user.tasks');

                Route::get('profile', 'Api\UserApiController@getUserProfile')->name('api.user.profile');

                Route::get('logout', 'Auth\LoginController@logout')->name('api.user.logout');
                Route::post('uploads', 'Api\UserApiController@uplaodsStore')->name('api.user.uploads-store');
                Route::delete('uploads/avatar', 'Api\UserApiController@uplaodsDeleteAvatar')->name('api.user.uploads-delete-avatar');

                // Update user information in users table
                Route::get('summary', 'Api\UserApiController@recommenderUserSummary')->name('api.user.summary');

                // Update user information in users table
                Route::get('activities', 'Api\UserApiController@recommenderUserActivities')->name('api.user.activities');

                // Update user information in users table
                Route::patch('/', 'Api\UserApiController@usersPatch')->name('api.user.users-patch');

                // User brands page
                Route::get('brands', 'Api\UserApiController@brands')->name('api.user.brands');

                // User charity options
                Route::get('charities', 'Api\UserApiController@charities')->name('api.user.charities');

                // charity-selections
                Route::post('charityselections', 'Api\UserApiController@charityselectionsStore')->name('api.user.charityselections-store');
                Route::get('charityselections', 'Api\UserApiController@charityselectionsList')->name('api.user.charityselections');
                Route::get('charityselections/latest', 'Api\UserApiController@charityselectionsLatest')->name('api.user.charityselections-latest');

                // aid-declaration
                Route::post('aiddeclarations', 'Api\UserApiController@aiddeclarationsStore')->name('api.user.aiddeclarations-store');
                Route::get('aiddeclarations', 'Api\UserApiController@aiddeclarationsList')->name('api.user.aiddeclarations');
                Route::get('aiddeclarations/latest', 'Api\UserApiController@aiddeclarationsLatest')->name('api.user.aiddeclarations-latest');

                // recommend urls
                Route::post('recommendurls', 'Api\UserApiController@recommendurlsStore')->name('api.user.recommendurls-store');
                Route::get('recommendurls', 'Api\UserApiController@recommendurlsList')->name('api.user.recommendurls');
                //Route::get('aiddeclarations/latest', 'Api\UserApiController@aiddeclarationsLatest')->name('api.user.aiddeclarations-latest');

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