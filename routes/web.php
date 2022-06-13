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

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('markQRAttendence', 'Auth\LoginController@all')->name('markQRAttendence');

Route::middleware('auth', "requirerole:admin")->prefix('admin')->group(function () {

    Route::get('/', 'AdminController@index')->name('/admin');

    // Event Handling
    Route::get('allevents', 'EventController@allevents')->name('allevents');
    Route::get('addevent', 'EventController@addevent')->name('addevent');
    Route::post('storeEvent', 'EventController@storeEvent')->name('storeEvent');
    Route::get('editevent/{event_id}', 'EventController@editevent')->name('editevent');
    Route::post('updateEvent/{event_id}', 'EventController@updateEvent')->name('updateEvent');
    Route::delete('deleteEvent/{id}', 'EventController@deleteEvent')->name('deleteEvent');

    Route::get('register-managers', 'ManagerController@registerManagers')->name('register-managers');
    Route::get('create-manager', 'UserProfileManagementController@createManager')->name('create-manager');
    Route::post('storeManager', 'UserProfileManagementController@storeManager')->name('storeManager');
    Route::get('profile/{user_id?}', 'UserProfileManagementController@getProfile')->name('profile');
    Route::post('profileUpdate/{id}', 'UserProfileManagementController@profileUpdate')->name('profileUpdate');

    // Client Management
    Route::get('clients', 'ClientController@allClients')->name('clients');
    Route::get('create-client', 'UserProfileManagementController@createClient')->name('create-client');
    Route::post('storeClient', 'UserProfileManagementController@storeClient')->name('storeClient');

    //EDIT CLIENT MANAGER
    Route::get('edit-client-manager/{user_id}', 'UserProfileManagementController@editClientManager')->name('edit-client-manager');
    Route::post('updateClientManager/{id}', 'UserProfileManagementController@updateClientManager')->name('updateClientManager');
    Route::delete('deleteClientManager/{id}', 'UserProfileManagementController@deleteClientManager')->name('deleteClientManager');

    //Handle Ajax requests
    Route::post('handleAjaxRequests', 'AjaxRequests@handleAjaxRequests')->name('handleAjaxRequests');

    //Check in timings
    Route::get('admin-visitor-check-in-timings', 'AdminController@checkInTiming')->name('admin-visitor-check-in-timings');
    Route::get('peak-hour-report', 'AdminController@peakHourReport')->name('peak-hour-report');
});

Route::middleware('auth', "requirerole:client")->prefix('client')->group(function () {
    Route::get('/', 'ClientController@index')->name('/client');
    Route::get('visitors', 'ClientController@visitors')->name('visitors');
    Route::get('check-in-timings', 'ClientController@checkInTiming')->name('check-in-timings');
    //Handle Ajax requests
    Route::post('handleAjaxRequests', 'AjaxRequests@handleAjaxRequests')->name('handleAjaxRequests');
    Route::get('profile/{user_id?}', 'UserProfileManagementController@getProfile')->name('clientProfile');
    Route::post('profileUpdate/{id}', 'UserProfileManagementController@profileUpdate')->name('clientProfileUpdate');
});

Route::middleware('auth', "requirerole:manager")->prefix('manager')->group(function () {
    Route::get('/', 'ManagerController@index')->name('/manager');
    Route::get('getChartData', 'ManagerController@getChartData')->name('getChartData');
    Route::get('attendence', 'ManagerController@attendence')->name('attendence');
    Route::get('allvisitors', 'ManagerController@allVisitors')->name('allvisitors');
    Route::get('addvisitor', 'ManagerController@addVisitor')->name('addvisitor');
    Route::post('storeVisitor', 'ManagerController@storeVisitor')->name('storeVisitor');
    Route::post('editVisitor', 'ManagerController@editVisitor')->name('editVisitor');
    Route::get('visitorDetails', 'ManagerController@visitorDetails')->name('visitorDetails');
    Route::post('deleteVisitor', 'ManagerController@deleteVisitor')->name('deleteVisitor');
    Route::get('addbulk', 'ManagerController@addBulk')->name('addbulk');
    Route::post('csvStoreVisitor', 'ManagerController@csvStoreVisitor')->name('csvStoreVisitor');
    Route::post('searchAttendee', 'ManagerController@searchAttendee')->name('searchAttendee');
    Route::post('markAttendance', 'ManagerController@markAttendance')->name('markAttendance');
    Route::post('markQRAttendance', 'ManagerController@markQRAttendance')->name('markQRAttendance');
    Route::post('markSingleAttendance', 'ManagerController@markSingleAttendance')->name('markSingleAttendance');
    Route::get('profile/{user_id?}', 'UserProfileManagementController@getProfile')->name('managerProfile');
    Route::post('profileUpdate/{id}', 'UserProfileManagementController@profileUpdate')->name('managerProfileUpdate');
    Route::get('visitorHistory', 'ManagerController@visitorHistory')->name('visitorHistory');
    Route::get('history', 'ManagerController@history')->name('history');
    Route::post('eventLocation', 'ManagerController@eventLocation')->name('eventLocation');
    Route::get('existsHistory', 'ManagerController@existsHistory')->name('existsHistory');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
