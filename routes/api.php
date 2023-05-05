<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {

});

Route::get('clientauth', 'AmbientController@authenticate');

Route::post('webhooks/create', 'SceneController@create');
Route::post('webhooks/close', 'SceneController@close');
Route::post('webhooks/list', 'SceneController@list');
Route::post('webhooks/delete', 'SceneController@delete');

Route::post('webhooks/test', 'SceneController@test');

Route::post('webhooks/debug/create', 'DebugRequestController@create');
Route::post('webhooks/debug/list', 'DebugRequestController@list');
Route::post('webhooks/debug/delete', 'DebugRequestController@delete');

// Submit Mailing List
Route::post('mailinglist', 'MailingListController@store');
Route::get('mailinglist', 'MailingListController@index');

// Analytics
Route::post('analytics/store', 'AnalyticsController@store');