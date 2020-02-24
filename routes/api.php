<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:apitest')->get('/user', function (Request $request) {
    return $request->user();
});

//  --------------------------------------   data sensor apis  ----------------------------------

Route::get('/login', 'ApiController@login');
Route::post('/login', 'ApiController@login');
Route::post('/allocatePatient', 'ApiController@allocatePatient');
Route::get('/api/allocatePatient', 'ApiController@allocatePatient');
Route::post('/completeAllocation', 'ApiController@completeAllocation');
Route::post('/getData', 'ApiController@getData');
Route::post('/updateStep', 'ApiController@updateStep');
Route::post('/getAllSensorData', 'ApiController@getAllSensorData');
Route::post('/resetAllocation', 'ApiController@resetAllocation');
Route::post('/getTestInfo', 'ApiController@getTestInfo');
Route::post('/addMessage', 'ApiController@addMessage');
Route::post('/editMessage', 'ApiController@editMessage');
Route::post('/deleteMessage', 'ApiController@deleteMessage');
Route::post('/getMessages', 'ApiController@getMessages');
Route::post('/deleteMessageByChk', 'ApiController@deleteMessageByChk');
Route::post('/getCities', 'ApiController@getCities');
Route::post('/getAddcompany', 'ApiController@getAddcompany');

Route::get('/test', 'ApiController@test');
Route::post('/test', 'ApiController@test');

Route::post('/deleteUserType', 'ApiController@deleteUserType');
Route::post('/deleteComapny', 'ApiController@deleteComapny');
Route::post('/deleteUser', 'ApiController@deleteUser');
Route::post('/deletePatient', 'ApiController@deletePatient');
Route::post('/deleteShip', 'ApiController@deleteShip');
Route::post('/deleteBill', 'ApiController@deleteBill');
Route::post('/deleteDevice', 'ApiController@deleteDevice');
Route::post('/getState', 'ApiController@getState');
Route::post('/getCity', 'ApiController@getCity');
Route::post('/updateWeight', 'ApiController@updateWeight');

// Visit Form part
Route::post('/addVisitForm', 'ApiController@addVisitForm');
Route::post('/editVisitForm', 'ApiController@editVisitForm');
Route::post('/send', 'ApiController@send');
Route::get('/send', 'ApiController@send');

Route::post('/checkStep', 'ApiTestController@checkStep');
Route::post('/startStep', 'ApiTestController@startStep');
Route::get('/startStep', 'ApiTestController@startStep');
Route::post('/completeStep', 'ApiTestController@completeStep');
Route::get('/completeStep', 'ApiTestController@completeStep');



// Review Test
Route::post('/ApiTest/DiabetReport',        'ApiTestController@getDiabetReport'     )->name('review.typeii');
