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

Route::get('monitoring/users', 'UserController@users');
Route::post('monitoring/users', 'UserController@newUser');
Route::get('/monitoring/users/{user}', 'UserController@deleteUsers');

Route::get('monitoring/contacts', 'ContactsController@contacts');
Route::post('monitoring/contacts', 'ContactsController@newContact');
Route::get('monitoring/contacts/{contact_name}', 'ContactsController@deleteContact');

Route::get('monitoring/groups', 'ContactGroupsController@groups');
Route::post('monitoring/groups', 'ContactGroupsController@newGroup');
Route::patch('monitoring/groups', 'ContactGroupsController@addUser');
Route::get('monitoring/groups/{group}', 'ContactGroupsController@deleteGroup');

Route::get('group/dropdown', 'ContactGroupsController@dropdown');

Route::get('monitoring/hosts', 'HostController@hosts');
Route::post('monitoring/hosts', 'HostController@newHost');
Route::patch('monitoring/hosts/service', 'HostController@addService');
Route::patch('monitoring/hosts/contact', 'HostController@addService');
Route::get('monitoring/hosts/delete/{host}', 'HostController@deleteHost');

Route::get('settings', 'SettingsController@settings');
