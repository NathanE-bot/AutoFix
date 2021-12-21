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

// ini route utk manggil controller workshop, cth endpoint: http://127.0.0.1/api/workshop
Route::get('workshop', 'Api\WorkshopController@allWorkshop'); //di set di controller untuk authentication
Route::middleware('auth:api')->get('auth/workshop', 'Api\WorkshopController@allWorkshop'); //di set di routes untuk authentication, jadi yg di controller gak perlu

//routes for CRUD
Route::post('workshop/create', 'Api\WorkshopController@create');
Route::get('workshop/getData/{id}', 'Api\WorkshopController@showById');
Route::put('workshop/update/{id}', 'Api\WorkshopController@update');
Route::delete('workshop/delete/{id}', 'Api\WorkshopController@destroy');

Route::get('workshopdetail','Api\WorkshopController@allWorkshopfix');

// Home Workshop
Route::get('getRecommendationWorkshop','Api\HomeController@getRecommendationWorkshop');


