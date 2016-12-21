<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});



Route::group(['middleware' => 'web'], function () {

    Route::auth();

    Route::get('/home', 'Site\HomeController@index');

    Route::get('/', 'Site\HomeController@index');

    Route::get('/control-panel', 'Admin\ControlPanel\ControlPanelController@index');

    Route::get('/settings', 'Admin\Settings\SettingsController@index');

    Route::post('/get-user-levels', 'Admin\ControlPanel\LevelsController@index');

    Route::post('/get-pagination', 'Admin\ControlPanel\LevelsController@index');

    Route::post('/submit-user-level', 'Admin\ControlPanel\LevelsController@store');

    Route::post('/submit-new-user', 'Admin\ControlPanel\UsersController@store');

    Route::post('/get-users-pagination', 'Admin\ControlPanel\UsersController@show_users');

    Route::post('/save-level-settings', 'Admin\Settings\LevelsController@save_level_settings');

    Route::post('/save-user-settings', 'Admin\Settings\UsersController@save_user_settings');

    Route::post('/save-general-settings', 'Admin\Settings\GeneralController@save_general_settings');

    /** Site Categories management
     *
     */

    Route::get('/category', 'Site\CategoryController@index');

    Route::get('/category/add', 'Site\CategoryController@add');

    Route::post('/category/submit', 'Site\CategoryController@submit_category');

    Route::get('/category/edit/{id}', 'Site\CategoryController@edit_category');

    Route::post('/category/update', 'Site\CategoryController@update_category');

    Route::post('/category/update/enable-disable', 'Site\CategoryController@enable_disable_category');

    Route::post('/category/search', 'Site\CategoryController@index');

    Route::get('/category/search', 'Site\CategoryController@index');

    /** Site Parameters management
     *
     */

    Route::get('/parameter', 'Site\ParameterController@index');

    Route::get('/parameter/add', 'Site\ParameterController@add');

    Route::post('/parameter/submit', 'Site\ParameterController@submit_parameter');

    Route::get('/parameter/edit/{id}', 'Site\ParameterController@edit_parameter');

    Route::post('/parameter/update', 'Site\ParameterController@update_parameter');

    Route::post('/parameter/update/enable-disable', 'Site\ParameterController@enable_disable_parameter');

    Route::post('/parameter/search', 'Site\ParameterController@index');

    Route::get('/parameter/search', 'Site\ParameterController@index');

    Route::post('/parameter/filter', 'Site\ParameterController@parameter_filtering');

    Route::get('/parameter/filter', 'Site\ParameterController@redirect_parameter_filtering');

    /** Site Objects management
     *
     */

    Route::get('/object', 'Site\ObjectController@index');

    Route::get('/object/add', 'Site\ObjectController@add');

    Route::post('/object/submit', 'Site\ObjectController@submit_object');

    Route::get('/object/edit/{id}', 'Site\ObjectController@edit_object');

    Route::get('/object/delete/{id}', 'Site\ObjectController@delete_object');

    Route::post('/object/update', 'Site\ObjectController@update_object');

    Route::post('/object/update/enable-disable', 'Site\objectController@enable_disable_object');

    Route::post('/object/search', 'Site\objectController@index');

    Route::get('/object/search', 'Site\objectController@index');

    Route::post('/object/filter', 'Site\objectController@object_filtering');

    Route::get('/object/filter', 'Site\objectController@redirect_object_filtering');

    /** Site Collections management
     *
     */

    Route::get('/collection', 'Site\CollectionController@index');

    Route::get('/collection/add', 'Site\CollectionController@add');

    Route::post('/collection/submit', 'Site\CollectionController@submit_collection');

    Route::get('/collection/edit/{id}', 'Site\CollectionController@edit_collection');

    Route::get('/collection/delete/{id}', 'Site\CollectionController@delete_collection');

    Route::post('/collection/update', 'Site\CollectionController@update_collection');

    Route::post('/collection/update/enable-disable', 'Site\CollectionController@enable_disable_collection');

    Route::post('/collection/search', 'Site\CollectionController@index');

    Route::get('/collection/search', 'Site\CollectionController@index');

});
