<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//AUTHENTICATION
Route::post('login', 'Api\UserController@login')->name('login');
Route::post('register', 'Api\UserController@register');

// forgot password
Route::post('doSendLinkForgotPassword', 'Api\ForgotPasswordController@forgot');
Route::post('doResetUserPassword', 'Api\ForgotPasswordController@reset');

//OTP email Auth
Route::get('tempUserID', 'Api\UserController@idTemp');
Route::post('otp', 'Api\UserController@otp');


// ini route utk manggil controller workshop, cth endpoint: http://127.0.0.1/api/workshop
// Route::get('workshop', 'Api\WorkshopController@allWorkshop'); //di set di controller untuk authentication
// Route::middleware('auth:api')->get('auth/workshop', 'Api\WorkshopController@allWorkshop'); //di set di routes untuk authentication, jadi yg di controller gak perlu

//routes for CRUD
Route::post('workshop/create', 'Api\WorkshopController@create');
Route::get('workshop/getData/{id}', 'Api\WorkshopController@showById');
Route::put('workshop/update/{id}', 'Api\WorkshopController@update');
Route::delete('workshop/delete/{id}', 'Api\WorkshopController@destroy');



Route::get('getRecommendationWorkshop','Api\HomeController@getRecommendationWorkshop')->name('homeWorkshopRecomendation');
Route::post('home/search', 'Api\HomeController@searchdata');


Route::get('getWorkshopByStatusUpdate', 'Api\WorkshopController@viewWorkshop')->name('ViewWorkshopByStatusUpdate');
Route::post('workshop/{workshopName}/{workshopAddress}/{statusHr}', 'Api\WorkshopController@filterworkshop')->name('filterWorkshop');
Route::get('workshop/filter', 'Api\WorkshopController@filterworkshop')->name('filterWorkshops');
Route::post('workshop/{id}', 'Api\WorkshopController@workshopDetailView')->name('getIDWorkshop');
Route::get('getWorkshopById','Api\WorkshopController@workshopDetailView')->name('viewWorkshopDetailByID');


Route::get('workshop/count','Api\WorkshopController@countDistance')->name('distance');

Route::post('makeSchedule/{id}', 'Api\ScheduleController@dataMakeSchedule')->name('getIDSchedule');
// Route::get('makeSchedule','Api\ScheduleController@dataMakeSchedule')->name('dataSchedule');

Route::get('email','mailController@index')->name('email');

//insurance
Route::get('InsuranceList','Api\InsuranceController@viewInsurance');
Route::post('FormInsurance', 'Api\InsuranceController@FormIsurance');


// message
Route::get('/chat', 'Api\ChatsController@index');
Route::get('/messages', 'Api\ChatsController@fetchMessages' );
Route::post('/messages', 'Api\ChatsController@sendMessage' );
Route::middleware('auth:api')->get('auth/messages', 'Api\ChatsController@allWorkshop'); //di set di routes untuk authentication, jadi yg di controller gak perlu
