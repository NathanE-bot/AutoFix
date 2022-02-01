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
Route::post('makeScheduleApi', 'Api\ScheduleController@makeScheduleApi');
Route::get('getScheduleByUserID', 'Api\ScheduleController@ShowDataScheduleByUserID');
Route::get('getDataFormMakeScheduleById', 'Api\ScheduleController@getDataFormMakeScheduleById');


//insurance
Route::get('getVendorInsuranceList','Api\InsuranceController@getVendorInsuranceList');
Route::get('getVendorInsuranceByID','Api\InsuranceController@getVendorInsuranceByID');
Route::post('makeInsuranceClaimApi', 'Api\InsuranceController@makeInsuranceClaimApi');
Route::get('getInsuranceStatusApi', 'Api\InsuranceController@getInsuranceStatusApi');
Route::get('getInsuranceDetailByStatusAccepted', 'Api\InsuranceController@getInsuranceDetailByStatusAccepted');
Route::get('getInsuranceDetailByStatusRejected', 'Api\InsuranceController@getInsuranceDetailByStatusRejected');
Route::get('downloadInsurancePDF', 'Api\InsuranceController@downloadPDFInsurance');
Route::get('getVendorByID', 'Api\InsuranceController@getVendorByID');
Route::post('makePathInsurance', 'Api\InsuranceController@makePathInsurance');
Route::post('updateInsurace', 'Api\InsuranceController@updateInsurace');




//API review
Route::post('formReviewAPI','Api\ReviewController@formReviewAPI');
Route::post('viewReviewAPI','Api\ReviewController@viewReviewAPI');
Route::post('countRatingForWorkshopByUserID','Api\ReviewController@countRatingForWorkshopByUserID');

//favorites
Route::post('makeFavoritesByWorkshopAndUserID','Api\FavoritesController@makeFavoritesByWorkshopAndUserID');
Route::get('getFavoritesByUserID','Api\FavoritesController@getFavoritesByUserID');
Route::post('deletFavoritesData','Api\FavoritesController@deletFavoritesData');

//history
Route::get('getHistoryByScheduleStatusAndUserID','Api\HistoryController@getHistoryByScheduleStatusAndUserID');

//profile user
Route::get('getDataProfileUserCustomer','Api\ProfileController@getDataProfileUserCustomer');
Route::post('updateDataUserProfile','Api\ProfileController@updateDataUserProfile');
Route::post('saveImg','Api\ProfileController@uploadImage');


// admin bengkel
Route::get('getScheduleByWorkshopIDAndAdminWorkshop','Api\AdminWorkshopController@getScheduleByWorkshopIDAndAdminWorkshop');
Route::post('acceptScheduleByAdmin','Api\AdminWorkshopController@acceptScheduleByAdmin');
Route::post('rejectedScheduleByAdmin','Api\AdminWorkshopController@rejectedScheduleByAdmin');
Route::get('getWorkshopDetailByUserID','Api\AdminWorkshopController@getWorkshopDetailByUserID');
Route::post('updateWorkshopForAdminBengkel','Api\AdminWorkshopController@updateWorkshopForAdminBengkel');
Route::post('updateLogoWorkshop','Api\AdminWorkshopController@updateLogoWorkshop');
Route::post('makeGaleryWorkshopPath','Api\AdminWorkshopController@makeGaleryWorkshopPath');
Route::post('updateGaleryWorkshop','Api\AdminWorkshopController@updateGaleryWorkshop');
Route::get('getAdminWorkshopProfile','Api\AdminWorkshopController@getAdminWorkshopProfile');
Route::get('getScheduleAcceptedByAdmin','Api\AdminWorkshopController@getScheduleAcceptedByAdmin');
Route::post('cancelScheduleByAdmin','Api\AdminWorkshopController@cancelScheduleByAdmin');
Route::post('doneScheduleByAdmin','Api\AdminWorkshopController@doneScheduleByAdmin');
Route::post('addNewWorkshopDetail','Api\AdminWorkshopController@addNewWorkshopDetail');
Route::post('deleteCarModel','Api\AdminWorkshopController@deleteCarModel');
Route::post('deleteCarType','Api\AdminWorkshopController@deleteCarType');
Route::post('addWorkshopService','Api\AdminWorkshopController@addWorkshopService');
Route::post('deleteWorkshopServiceByID','Api\AdminWorkshopController@deleteWorkshopServiceByID');
Route::post('deleteWorkshopServiceByStatusAndID','Api\AdminWorkshopController@deleteWorkshopServiceByStatusAndID');
Route::get('countAllDataWorkshop','Api\AdminWorkshopController@countAllDataWorkshop');
Route::get('SumAllPriceEstimationWorkshop','Api\AdminWorkshopController@SumAllPriceEstimationWorkshop');
Route::get('countWorkshopByStatus','Api\AdminWorkshopController@countWorkshopByStatus');
Route::get('getYearWorkshopForFilterHome','Api\AdminWorkshopController@getYearWorkshopForFilterHome');



//ADMIN INSURANCE
Route::get('getDataIncomingInsuranceRequestByAdminID','Api\AdminInsuranceController@getDataIncomingInsuranceRequestByAdminID');
Route::post('uploadPDFInsurance','Api\AdminInsuranceController@uploadPDFInsurance');
Route::post('acceptInsuranceClaim','Api\AdminInsuranceController@acceptInsuranceClaim');
Route::get('getAdminInsuranceDetails','Api\AdminInsuranceController@getAdminInsuranceDetails');
Route::post('rejectInsuranceClaim','Api\AdminInsuranceController@rejectInsuranceClaim');
Route::get('getInsuranceHistory','Api\AdminInsuranceController@getInsuranceHistory');
Route::get('countDataTotalClaimedInsurance', 'Api\AdminInsuranceController@countDataTotalClaimedInsurance');
Route::get('getYearInsuranceForFilterHome', 'Api\AdminInsuranceController@getYearInsuranceForFilterHome');
Route::get('getYearInsuranceForFilterHome', 'Api\AdminInsuranceController@getYearInsuranceForFilterHome');
Route::get('countDataTotalCLaimedInsuranceByStatus', 'Api\AdminInsuranceController@countDataTotalCLaimedInsuranceByStatus');



