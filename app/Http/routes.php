<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
	Route::POST('auth/login','AuthController@login');
	Route::POST('auth/reset-password','AuthController@resetPassword');
	Route::POST('auth/register','AuthController@register');
	Route::get('auth/logout','AuthController@logout');
	Route::group(['middleware' => 'jwt.auth', 'jwt.refresh'], function () {
		Route::get('runs/list', 'RunController@lists');
		Route::get('runs/detail', 'RunController@detail');
		Route::POST('runs/add', 'RunController@add');
		Route::POST('runs/update', 'RunController@update');

		Route::get('parcels/list', 'ParcelController@lists');
		Route::get('parcels/detail', 'ParcelController@detail');
		Route::POST('parcels/add', 'ParcelController@add');
		Route::POST('parcels/update', 'ParcelController@update');
		Route::POST('parcels/rearrange', 'ParcelController@rearrange');
		Route::POST('parcels/delete', 'ParcelController@delete');
		Route::POST('parcels/delivered', 'ParcelController@delivered');

		Route::get('favourites/list', 'FavouriteController@lists');
		Route::POST('favourites/add', 'FavouriteController@add');
		Route::POST('favourites/remove', 'FavouriteController@delete');

		Route::POST('offline/update', 'OfflineController@update');
	});
});

Route::get('user/active/{key?}',['as' => 'api.user.active', 'uses' => 'UserController@active']);

Route::resource('admin', 'AdminController');
Route::resource('user', 'UserController');
Route::resource('runs', 'RunsController');
Route::get('parcels', 'RunsController@parcels');
Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm');
Route::post('password/reset','Auth\PasswordController@reset');

Route::post('user/login', 'UserController@login');
Route::post('user/reset_password', 'UserController@reset_password');
Route::get('statistic/dashboard', 'StatisticController@dashboard');
