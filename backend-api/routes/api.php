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
Route::post('doVerififcationEmailWithOtp', 'Api\UserController@otp');
Route::post('doResendOtp', 'Api\UserController@resendOtp');


// ini route utk manggil controller workshop, cth endpoint: http://127.0.0.1/api/workshop
// Route::get('workshop', 'Api\WorkshopController@allWorkshop'); //di set di controller untuk authentication
// Route::middleware('auth:api')->get('auth/workshop', 'Api\WorkshopController@allWorkshop'); //di set di routes untuk authentication, jadi yg di controller gak perlu

//routes for CRUD
Route::post('workshop/create', 'Api\WorkshopController@create');
Route::get('workshop/getData/{id}', 'Api\WorkshopController@showById');
Route::put('workshop/update/{id}', 'Api\WorkshopController@update');
Route::delete('workshop/delete/{id}', 'Api\WorkshopController@destroy');


// Route API Workshops
Route::get('getRecommendationWorkshop','Api\HomeController@getRecommendationWorkshop')->name('homeWorkshopRecomendation');
Route::post('home/search', 'Api\HomeController@searchdata');

Route::get('getAllWorkshop', 'Api\WorkshopController@getAllWorkshop');
Route::post('getWorkshopApi', 'Api\WorkshopController@getWorkshopApi');
Route::post('workshop/{id}', 'Api\WorkshopController@workshopDetailView')->name('getIDWorkshop');
Route::get('getWorkshopById','Api\WorkshopController@workshopDetailView')->name('viewWorkshopDetailByID');
Route::get('filterDataWorkshop','Api\WorkshopController@filterDataWorkshop')->name('filterDataWorkshop');


Route::post('doCountDistanceFromCurrPos','Api\WorkshopController@countDistance')->name('distance');
//schedule
Route::post('MakeSchedule', 'Api\ScheduleController@formSchedule');
Route::post('ViewSchedule', 'Api\ScheduleController@ShowDataSchedule');

Route::get('email','mailController@index')->name('email');

//insurance
Route::get('InsuranceList','Api\InsuranceController@viewInsurance');
Route::post('FormInsurance', 'Api\InsuranceController@FormIsurance');
Route::post('viewInsurance', 'Api\InsuranceController@ViewInsuranceDetail');

//API review
Route::get('InsuranceList','Api\InsuranceController@viewInsurance');
