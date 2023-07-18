<?php

// use App\Http\Controllers\Apis\AuthApiController;
// use App\Http\Controllers\Apis\RequestController;
// use App\Http\Controllers\Apis\UserApiController;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// */

// Route::group(['middlware'=> 'version'],function () {
//     Route::post('user/sign_up', [AuthApiController::class, 'sign_up']);
//     Route::post('user/login/', [AuthApiController::class, 'login']);
//     Route::post('user/social_login', [AuthApiController::class, 'social_login']);
//     Route::post('user/update_profile', [UserApiController::class, 'update_profile']);
//     Route::post('user/change_password', [UserApiController::class, 'change_password']);
//     Route::post('user/reset_password', [UserApiController::class, 'reset_password']);


//     Route::post('user/get_ride_estimate', [RequestController::class, 'get_ride_estimate']);


//     Route::middleware('auth:api')->get('/user', function (Request $request) {

//         return $request->user();
//     });
//     Route::middleware('auth')->group(function () {
//     });
// });
