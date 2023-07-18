<?php

use App\Http\Controllers\Apis\v1\DriverApiController;
use App\Http\Controllers\Apis\v1\AuthApiController;
use App\Http\Controllers\Apis\v1\RequestController;
use App\Http\Controllers\Apis\v1\UserApiController;
use App\Http\Controllers\Dashboard\UserController;
use App\Models\DriverInformation;
use App\Models\Estimate;
use App\Models\RideRequest;
use App\Models\User;
use Doctrine\DBAL\Types\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
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

Route::get('app_data', [DriverApiController::class, 'app_data']);
Route::get('gethomedata', [AuthApiController::class, 'gethomedata']);

//////// User APIs
Route::post('user/sign_up', [AuthApiController::class, 'sign_up']);
Route::post('user/login/', [AuthApiController::class, 'login']);
Route::post('user/social_login', [AuthApiController::class, 'social_login']);
Route::post('user/existPhonEmail', [UserApiController::class, 'existPhonEmail']);
Route::post('user/reset_password', [UserApiController::class, 'reset_password']);

//////// Users APIs
Route::group(['middleware' => ['auth:api', 'isuser']], function () {
    Route::post('user/update_profile', [UserApiController::class, 'update_profile']);
    Route::post('user/change_password', [UserApiController::class, 'change_password']);
    Route::post('user/reset_image', [UserApiController::class, 'reset_image']);
    Route::get('payment_methods', [UserApiController::class, 'payment_methods']);
    Route::post('user/get_ride_estimate', [RequestController::class, 'get_ride_estimate']);
    Route::post('user/request_a_ride', [RequestController::class, 'request_a_ride']);
    Route::get('user/ride_request/{uuid}', [RequestController::class, 'ride_request']);
    Route::get('user/ride_request', [RequestController::class, 'user_ride_request']);
    Route::get('user/requests_history', [RequestController::class, 'requests_history']);
    Route::post('user/rate_driver', [DriverApiController::class, 'rate_driver']);
    Route::post('user/cancel_request', [RequestController::class, 'cancel_request']);
    Route::get('user/notifications', [UserApiController::class, 'get_notification']);
    Route::get('user/promo_code/{id}', [RequestController::class, 'promo_code']);
});

//////// Driver APIs
Route::post('driver/sign_up', [DriverApiController::class, 'driver_sign_up']);
Route::post('driver/login', [DriverApiController::class, 'driver_login']);
Route::post('upload_documents', [DriverApiController::class, 'upload_documents']);
Route::post('driver/reset_password', [UserApiController::class, 'reset_password']);
Route::group(['middleware' => ['auth:api', 'isdriver']], function () {
    Route::post('driver/update_profile', [UserApiController::class, 'update_profile']);
    Route::post('driver/change_password', [UserApiController::class, 'change_password']);
    Route::post('driver/reset_image', [UserApiController::class, 'reset_image']);
    Route::post('driver/get_requests', [DriverApiController::class, 'get_requests']);
    Route::post('driver/accept_request', [DriverApiController::class, 'accept_request']);
    Route::get('driver/notifications', [UserApiController::class, 'get_notification']);
    Route::get('driver/requests_history', [RequestController::class, 'requests_history']);
    Route::get('driver/ride_request', [DriverApiController::class, 'driver_ride_request']);
    Route::post('driver/get_price', [DriverApiController::class, 'get_price']);
    Route::post('driver/driver_credit', [DriverApiController::class, 'driver_credit']);
    Route::get('driver/get_cards', [DriverApiController::class, 'get_cards']);
    Route::get('driver/get_driver_balance', [DriverApiController::class, 'driver_balance']);
});

/////// Shared APIs
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('change_status', [RequestController::class, 'change_status_request']);
    Route::post('save_token', [UserApiController::class, 'save_token']);
    Route::get('remove_token', [UserApiController::class, 'remove_token']);
    Route::get('logout', [UserApiController::class, 'remove_token']);
    Route::post('add_language', [UserApiController::class, 'add_language']);
});
