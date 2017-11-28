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


Route::group(['prefix'=>'api','middleware' => 'auth:api'], function()
{
    //Login Routes

    Route::post('/login', 'AuthController@login');

    Route::post('/forgotpassword', 'AuthController@forgotPassword');

    Route::post('/changepassword', 'AuthController@changePassword');

    //Organization Routes

    Route::get('/organization', 'OrganizationController@index');

    Route::get('/organization/get/{id}', 'OrganizationController@get');

    Route::get('/admin/{id}/organization', 'OrganizationController@getAdminOrg');

    Route::get('/organization/getAll', 'OrganizationController@getAll');

    Route::post('/organization/update/{id}', 'OrganizationController@update');

    Route::get('/organization/delete/{id}', 'OrganizationController@delete');

    Route::get('/organization/trashed', 'OrganizationController@trashed');

    Route::post('/organization/restore/{id}', 'OrganizationController@restore');

    Route::post('/organization/add', 'OrganizationController@add');

    //Organization Address Routes

    Route::get('/organization/address/{id}', 'OrgAddressController@getAllAddress');

    Route::get('/organization/address/{org_id}/edit/{id}', 'OrgAddressController@get');

    Route::post('/organization/address/update/{id}', 'OrgAddressController@update');

    Route::get('/organization/trashed/address/{id}', 'OrgAddressController@getTrashedOrgAddress');

    Route::post('/organization/address/add/{id}', 'OrgAddressController@add');

    Route::get('/organization/address/delete/{id}', 'OrgAddressController@delete');

    Route::get('/organization/address/restore/{id}', 'OrgAddressController@restore');

    Route::get('/organization/address/trashed/{id}', 'OrgAddressController@trashed');

    //Admin Routes

    Route::get('/admin/organization/{org_id}', 'AdminController@index');

    Route::get('/admin/get/{id}', 'AdminController@get');

    Route::post('/admin/add', 'AdminController@add');

    Route::get('/admin/trashed/{org_id}', 'AdminController@trashed');

    Route::post('/admin/restore/{id}', 'AdminController@restore');

    Route::post('/admin/delete/{id}', 'AdminController@delete');

    Route::post('/admin/update/{id}', 'AdminController@update');

    //Employee Routes

    Route::get('/employee/organization/{org_id}', 'EmployeeController@index');

    Route::get('/employee/get/{id}', 'EmployeeController@get');

    Route::post('/employee/add', 'EmployeeController@add');

    Route::post('/employee/update/{id}', 'EmployeeController@update');

    Route::post('/employee/delete/{id}', 'EmployeeController@delete');

    Route::post('/employee/restore/{id}', 'EmployeeController@restore');

    Route::get('/employee/trashed/{org_id}', 'EmployeeController@trashed');

    //Service Routes

    Route::get('/service/{org_id}', 'ServiceController@index');

    Route::get('/service/{org_id}/get/{id}', 'ServiceController@get');

    Route::get('/service/get/{org_id}', 'ServiceController@ajaxGetServices');

    Route::post('/service/update/{org_id}/{id}', 'ServiceController@update');

    Route::post('/service/add', 'ServiceController@add');

    Route::get('/service/{org_id}/delete/{id}', 'ServiceController@delete');

    Route::get('/service/{org_id}/restore/{id}', 'ServiceController@restore');

    Route::get('/service/trashed/{org_id}', 'ServiceController@trashed');

    //Schedule Routes

    Route::get('/schedule/organization/{org_id}/{id}', 'ScheduleController@index');

    Route::post('/schedule/add/{org_id}/{id}', 'ScheduleController@add');

    Route::post('/schedule/organization/{org_id}/{id}', 'ScheduleController@update');

    //Appointment Routes

    Route::get('/appointment/{org_id}/{emp_id}', 'AppointmentController@index');

    Route::post('/appointment/{org_id}/{emp_id}/{id}', 'AppointmentController@update');

    Route::post('/appointment/{org_id}/{emp_id}/add/new', 'AppointmentController@add');

    Route::post('/appointment/{org_id}/{emp_id}/delete/{id}', 'AppointmentController@delete');

    //Client routes

    Route::get('/client/{org_id}', 'ClientController@getClients');

    //Search results routes

    Route::get('/search/1/{org_id}/{user_id}', 'SuperAdminSearchController@index');

    Route::get('/search/2/{org_id}/{user_id}', 'AdminSearchController@index');

    Route::get('/search/3/{org_id}/{user_id}', 'EmployeeSearchController@index');
});

Auth::routes();
