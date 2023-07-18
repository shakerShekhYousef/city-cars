<?php

use App\Http\Controllers\Apis\AuthApiController;
use App\Http\Controllers\Apis\RequestController;
use App\Http\Controllers\Apis\UserApiController;
use App\Http\Controllers\Apis\DriverApiController;

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

//////// User APIs
Route::post('user/sign_up', [AuthApiController::class, 'sign_up']);
Route::post('user/login/', [AuthApiController::class, 'login']);
Route::post('user/social_login', [AuthApiController::class, 'social_login']);
Route::post('user/existPhonEmail', [UserApiController::class, 'existPhonEmail']);
Route::post('user/reset_password', [UserApiController::class, 'reset_password']);

Route::group(['middleware' => ['auth:api','isuser']], function () {
    Route::post('user/update_profile', [UserApiController::class, 'update_profile']);
    Route::post('user/change_password', [UserApiController::class, 'change_password']);
    Route::post('user/reset_image', [UserApiController::class, 'reset_image']);
    Route::get('payment_methods', [UserApiController::class, 'payment_methods']);
    Route::post('user/get_ride_estimate', [RequestController::class, 'get_ride_estimate']);
    Route::get('user/notifications', [UserApiController::class, 'notifications']);


});

//////// Driver APIs
Route::post('driver/sign_up', [DriverApiController::class, 'driver_sign_up']);
Route::post('driver/login', [DriverApiController::class, 'driver_login']);
Route::post('driver/social_login', [DriverApiController::class, 'driver_social_login']);

Route::get('app_data', [DriverApiController::class, 'app_data']);
Route::group(['middleware' => ['auth:api','isdriver']], function () {
    Route::post('upload_documents', [DriverApiController::class, 'upload_documents']);
});
