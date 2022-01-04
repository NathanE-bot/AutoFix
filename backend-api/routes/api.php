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

// EXAMPLE--
// ini route utk manggil controller workshop, cth endpoint: http://127.0.0.1/api/workshop
// Route::get('workshop', 'Api\WorkshopController@allWorkshop'); //di set di controller untuk authentication
// Route::middleware('auth:api')->get('auth/workshop', 'Api\WorkshopController@allWorkshop'); //di set di routes untuk authentication, jadi yg di controller gak perlu

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

//routes for CRUD
Route::post('workshop/create', 'Api\WorkshopController@create');
Route::get('workshop/getData/{id}', 'Api\WorkshopController@showById');
Route::put('workshop/update/{id}', 'Api\WorkshopController@update');
Route::delete('workshop/delete/{id}', 'Api\WorkshopController@destroy');
Route::get('email','mailController@index')->name('email');

// Route API Workshops
Route::get('getRecommendationWorkshop','Api\HomeController@getRecommendationWorkshop')->name('homeWorkshopRecomendation');
Route::post('home/search', 'Api\HomeController@searchdata');
Route::get('getAllWorkshop', 'Api\WorkshopController@getAllWorkshop');
Route::post('getWorkshopApi', 'Api\WorkshopController@getWorkshopApi');
Route::get('getWorkshopById','Api\WorkshopController@workshopDetailView')->name('viewWorkshopDetailByID');
Route::get('filterDataWorkshop','Api\WorkshopController@filterDataWorkshop')->name('filterDataWorkshop');
Route::post('getUserWorkshopByWorkshopId','Api\WorkshopController@getUserProfile')->name('getUserProfile');
Route::post('doCountDistanceFromCurrPos','Api\WorkshopController@countDistance')->name('distance');


//schedule
Route::middleware('auth:api')->post('makeScheduleApi', 'Api\ScheduleController@makeScheduleApi');
Route::get('getScheduleByUserID', 'Api\ScheduleController@ShowDataScheduleByUserID');
Route::get('getDataFormMakeScheduleById', 'Api\ScheduleController@getDataFormMakeScheduleById');


//insurance
Route::get('getVendorInsuranceList','Api\InsuranceController@getVendorInsuranceList');
Route::post('makeInsuranceClaimApi', 'Api\InsuranceController@makeInsuranceClaimApi');
Route::get('getInsuranceStatusApi', 'Api\InsuranceController@getInsuranceStatusApi');
Route::get('getInsuranceDetailByStatusAccepted', 'Api\InsuranceController@getInsuranceDetailByStatusAccepted');
Route::get('getInsuranceDetailByStatusRejected', 'Api\InsuranceController@getInsuranceDetailByStatusRejected');
Route::get('downloadInsurancePDF', 'Api\InsuranceController@downloadInsurancePDF');



//API review
Route::post('formReviewAPI','Api\ReviewController@formReviewAPI');
// Route::post('viewReviewAPI','Api\ReviewController@viewReviewAPI');

//favorites
Route::post('makeFavoritesByWorkshopAndUserID','Api\FavoritesController@makeFavoritesByWorkshopAndUserID');
Route::get('getFavoritesByUserID','Api\FavoritesController@getFavoritesByUserID');
Route::post('deletFavoritesData','Api\FavoritesController@deletFavoritesData');

//history
Route::get('getHistoryByScheduleStatusAndUserID','Api\HistoryController@getHistoryByScheduleStatusAndUserID');
