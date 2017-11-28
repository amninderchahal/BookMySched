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
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', 'AuthController@login');

Route::get('/logout', 'AuthController@logout');

Route::get('/forgotpassword', function () {
    return view('auth.forgotpassword');
});

Route::get('/error', function () {
    return view('error');
});

Route::post('/forgotpassword', 'AuthController@forgotPassword');

Route::group(['middleware' => 'checkAuth'], function()
{
    Route::get('/changepassword', function(){
        return view('auth.changepassword');
    });

    Route::post('/changepassword', 'AuthController@changePassword');

    Route::get('/home', function () {
        return view('home');
    });

    Route::group(['middleware' => 'checkSuperAdmin'], function()
    {
        // All Organisations Routes

        Route::get('/organization', 'OrganizationsController@index');

        Route::get('/organization/new', function(){
            return view('organization.new');
        });

        Route::post('/organization/add', 'OrganizationsController@newOrganization');

        Route::post('/organization/edit/{id}', 'OrganizationsController@updateOrganization');

        Route::get('/organization/edit/{id}', 'OrganizationsController@editOrganization');

        Route::get('/organization/delete/{id}', 'OrganizationsController@deleteOrganization');

        Route::get('/organization/trashed', 'OrganizationsController@trashed');

        Route::get('/organization/restore/{id}', 'OrganizationsController@restoreOrganization');

        // Organisation Address Route in OrganizationController

        Route::get('/organization/address/add/{id}', 'OrganizationsController@get');

        // All Organisation Address Routes

        Route::get('/organization/address/{id}', 'OrgAddressController@getAddress');

        Route::get('/organization/trashed/address/{id}', 'OrgAddressController@getTrashedOrgAddress');

        Route::post('/organization/address/add/{id}', 'OrgAddressController@add');

        Route::get('/organization/address/edit/{org_id}/{id}', 'OrgAddressController@edit');

        Route::post('/organization/address/edit/{org_id}/{id}', 'OrgAddressController@update');

        Route::get('/organization/address/delete/{org_id}/{id}', 'OrgAddressController@delete');

        Route::get('/organization/address/restore/{org_id}/{id}', 'OrgAddressController@restore');

        Route::get('/organization/address/trashed/{id}', 'OrgAddressController@trashedAddresses');


        // All Admins Routes

        Route::get('/admin/organization/{org_id}', 'AdminsController@index');

        Route::get('/admin/new', 'AdminsController@newAdmin');

        Route::post('/admin/new', 'AdminsController@addAdmin');

        Route::get('/admin/edit/{id}', 'AdminsController@editAdmin');

        Route::post('/admin/update/{id}', 'AdminsController@updateAdmin');

        Route::get('/admin/delete/{org_id}/{id}', 'AdminsController@deleteAdmin');

        Route::get('/admin/trashed/{org_id}', 'AdminsController@trashed');

        Route::get('/admin/restore/{id}', 'AdminsController@restoreAdmin');
    });

    Route::group(['middleware' => 'checkAdmin'], function()
    {
        // All Employees Routes

        Route::get('/employee/organization/{org_id}', 'EmployeesController@index');

        Route::get('/employee/edit/{id}', 'EmployeesController@edit');

        Route::get('/employee/new', 'EmployeesController@newEmployee');

        Route::post('/employee/new', 'EmployeesController@addEmployee');

        Route::post('/employee/update/{id}', 'EmployeesController@updateEmployee');

        Route::get('/employee/delete/{id}', 'EmployeesController@deleteEmployee');

        Route::get('/employee/trashed/{org_id}', 'EmployeesController@trashed');

        Route::get('/employee/restore/{id}', 'EmployeesController@restoreEmployee');

        // All Services Routes

        Route::get('/service/organization/{org_id}', 'ServicesController@index');

        Route::get('/service/edit/{org_id}/{id}', 'ServicesController@get');

        Route::post('/service/update/{org_id}/{id}', 'ServicesController@update');

        Route::get('/service/new', function(){
            return view('service.new');
        });

        Route::post('/service/add', 'ServicesController@add');

        Route::get('/service/delete/{org_id}/{id}', 'ServicesController@delete');

        Route::get('/service/restore/{org_id}/{id}', 'ServicesController@restore');

        Route::get('/service/trashed/{org_id}', 'ServicesController@trashed');

        // All Employee Schedule Routes

        Route::get('/schedule/organization/{org_id}', 'ScheduleController@index');

        Route::get('/schedule/organization/{org_id}/{id}', 'ScheduleController@getEmpSchedule');

        Route::post('/schedule/organization/{org_id}/{id}', 'ScheduleController@update');

        Route::get('/schedule/new/{org_id}/{id}', 'ScheduleController@newSchedule');

        Route::post('/schedule/new/{org_id}/{id}', 'ScheduleController@addSchedule');

        //All Employees Appointments

        Route::get('/appointment/organization/{org_id}', 'AppointmentController@index');
    });

    // All Appointments Routes

        Route::get('/appointment/organization/{org_id}/{emp_id}', 'AppointmentController@getEmpAppointments');

        Route::post('/appointment/organization/{org_id}/{emp_id}/{id}', 'AppointmentController@update');

        Route::post('/appointment/organization/{org_id}/{emp_id}/add/new', 'AppointmentController@add');

        Route::get('/appointment/organization/{org_id}/{emp_id}/delete/{id}', 'AppointmentController@delete');

        //AJAX routes
        Route::get('/client/{org_id}', 'ClientsController@getClients');

        Route::get('/service/get/{org_id}', 'ServicesController@ajaxGetServices');

        Route::get('/search', 'SearchController@index');
});
