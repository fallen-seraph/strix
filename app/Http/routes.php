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

//monitoring users routes
Route::get('monitoring/users', 'UserController@users');
Route::post('monitoring/users', 'UserController@newUser');
Route::get('/monitoring/users/delete/{user}', 'UserController@deleteUsers');


//monitoring contacts routes
Route::get('monitoring/contacts', 'ContactsController@contacts');
Route::post('monitoring/contacts', 'ContactsController@newContact');
Route::get('monitoring/contacts/delete/{contact_id}', 'ContactsController@deleteContact');

Route::get('monitoring/contacts/update/{alias}', 'UpdatesController@contact');
Route::patch('monitoring/contacts/update', 'UpdatesController@updateContact');


//monitoring groups routes
Route::get('monitoring/groups', 'ContactGroupsController@groups');
Route::post('monitoring/groups', 'ContactGroupsController@newGroup');
Route::patch('monitoring/groups/contactUpdate', 'ContactGroupsController@addOrRemoveContact');
Route::get('monitoring/groups/delete/{group}', 'ContactGroupsController@deleteGroup');

Route::get('monitoring/groups/rename/{group}', 'UpdatesController@groupName');
Route::patch('monitoring/groups/rename', 'UpdatesController@renameGroup');


//monitoring hosts routes
Route::get('monitoring/hosts', 'HostController@hosts');
Route::post('monitoring/hosts', 'HostController@newHost');
Route::patch('monitoring/hosts/service', 'HostController@addService');
Route::get('monitoring/hosts/delete/{host}', 'HostController@deleteHost');

Route::get('monitoring/hosts/update/{host}', 'UpdatesController@host');
Route::patch('monitoring/hosts/update', 'UpdatesController@updateHost');

//apis for drop downs across all blades
Route::get('group/dropdown', 'ApiController@contactGroupDropdown');

Route::get('settings', 'SettingsController@settings');
