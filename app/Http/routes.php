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

//pages routes
Route::get('/', 'pagesController@index');
Route::get('pricing', 'pagesController@pricing');
Route::get('tour', 'pagesController@tour');
Route::get('support', 'pagesController@support');
Route::get('about', 'pagesController@aboutus');

//login routes
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

// Registration Routes...
Route::get('register', 'RegisterController@showForm');
Route::post('register', 'RegisterController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

//monitoring routes
Route::get('monitoring', 'monitoringController@index');
Route::get('monitoring/hosts', 'monitoringController@hosts');
Route::get('monitoring/users', 'monitoringController@users');
Route::get('monitoring/contacts', 'monitoringController@contacts');
Route::get('monitoring/contactgroups', 'monitoringController@contactgroups');
Route::get('monitoring/settings', 'monitoringController@settings');
