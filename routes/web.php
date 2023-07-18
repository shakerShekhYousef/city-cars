<?php

use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CarTypeController;
use App\Http\Controllers\Dashboard\CardController;
use App\Http\Controllers\Dashboard\NotificationController;

use App\Http\Controllers\Dashboard\VehicleInformationController;
use App\Http\Controllers\Dashboard\CarModelController;
use App\Http\Controllers\Dashboard\PromoCodeController;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('pages.index');
// });

Route::get('user/password_reset/{token}', [UserController::class, 'password_reset'])->name('password-reset');
Route::post('user/updatePassword', [UserController::class, 'updatePassword'])->name('password-update');

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('users/', [UserController::class, 'index'])->name('userslist');
    Route::get('users.user', [UserController::class, 'create'])->name('userscreate');
    Route::post('users.store', [UserController::class, 'store'])->name('usersstore');
    Route::get('users/{id?}', [UserController::class, 'show'])->name('usersshow');
    Route::post('users.user/{id?}', [UserController::class, 'delete'])->name('usersdelete');
    Route::post('/user/{id?}/user_verified', [UserController::class, 'userverified'])->name('user.user_verified');
    Route::get('balance.edit/{id?}', [UserController::class, 'balanceedit'])->name('balanceedit');
    Route::post('balance.update/{id?}', [UserController::class, 'balanceupdate'])->name('balanceupdate');
    Route::get('blockuser/{id}', [UserController::class,'block_user'])->name('block_user');

    Route::get('vehicleinformation/{id?}', [VehicleInformationController::class, 'show'])->name('vehicleinformationshow');
    Route::get('edit/{id?}', [VehicleInformationController::class, 'edit'])->name('editvehicleinfo');
    Route::post('update/{id?}', [VehicleInformationController::class, 'update'])->name('updatevehicleinfo');

    Route::get('cartypes/', [CarTypeController::class, 'index'])->name('cartypeslist');
    Route::get('cartypes.car', [CarTypeController::class, 'create'])->name('cartypescreate');
    Route::get('cartypes.edit/{id?}', [CarTypeController::class, 'edit'])->name('cartypesedit');
    Route::post('cartypes.store', [CarTypeController::class, 'store'])->name('cartypesstore');
    Route::post('cartypes.update/{id?}', [CarTypeController::class, 'update'])->name('cartypesupdate');
    Route::post('cartypes.car/{id?}', [CarTypeController::class, 'delete'])->name('cartypesdelete');

    Route::get('carmodels/', [CarModelController::class, 'index'])->name('carmodelslist');
    Route::get('carmodels.car', [CarModelController::class, 'create'])->name('carmodelscreate');
    Route::get('carmodels.edit/{id?}', [CarModelController::class, 'edit'])->name('carmodelsedit');
    Route::post('carmodels.store', [CarModelController::class, 'store'])->name('carmodelsstore');
    Route::post('carmodels.update/{id?}', [CarModelController::class, 'update'])->name('carmodelsupdate');
    Route::post('carmodels.car/{id?}', [CarModelController::class, 'delete'])->name('carmodelsdelete');

    Route::get('cards/', [CardController::class, 'index'])->name('cardslist');
    Route::get('cards.card', [CardController::class, 'create'])->name('cardscreate');
    Route::get('cards.edit/{id?}', [CardController::class, 'edit'])->name('cardsedit');
    Route::post('cards.store', [CardController::class, 'store'])->name('cardsstore');
    Route::post('cards.update/{id?}', [CardController::class, 'update'])->name('cardsupdate');
    Route::post('cards.card/{id?}', [CardController::class, 'delete'])->name('cardsdelete');
    Route::get('/notification', [NotificationController::class, 'index'])->name('lists');
    Route::post('/submit', [NotificationController::class, 'submit'])->name('submit');

    Route::get('/driver.prcentage', [UserController::class, 'driverprcentage'])->name('driverprcentage');
    Route::post('/driver.prcentage', [UserController::class, 'driverprcentage'])->name('driverprcentage.post');
    Route::get('/tripreports', [UserController::class, 'tripreports'])->name('tripreports');

    Route::get('/review', [UserController::class, 'review'])->name('review');

    ////homecontent
    Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
    Route::post('/aboutupdate', [App\Http\Controllers\HomeController::class, 'aboutupdate'])->name('aboutupdate');
    Route::get('/terms', [App\Http\Controllers\HomeController::class, 'terms'])->name('terms');
    Route::post('/termsupdate', [App\Http\Controllers\HomeController::class, 'termsupdate'])->name('termsupdate');
    Route::get('/privacypolicy', [App\Http\Controllers\HomeController::class, 'privacypolicy'])->name('privacypolicy');
    Route::post('/privacypolicyupdate', [App\Http\Controllers\HomeController::class, 'privacypolicyupdate'])->name('privacypolicyupdate');
    Route::get('/contactus', [App\Http\Controllers\HomeController::class, 'contactus'])->name('contactus');
    Route::post('/contactusupdate', [App\Http\Controllers\HomeController::class, 'contactusupdate'])->name('contactusupdate');
    Route::get('/emailus', [App\Http\Controllers\HomeController::class, 'emailus'])->name('emailus');
    Route::post('/emailusupdate', [App\Http\Controllers\HomeController::class, 'emailusupdate'])->name('emailusupdate');

    Route::get('promocodes/', [PromoCodeController::class, 'index'])->name('promocodeslist');
    Route::get('promocodes.promocode', [PromoCodeController::class, 'create'])->name('promocodescreate');
    Route::get('promocodes.edit/{id?}', [PromoCodeController::class, 'edit'])->name('promocodesedit');
    Route::post('promocodes.store', [PromoCodeController::class, 'store'])->name('promocodesstore');
    Route::post('promocodes.update/{id?}', [PromoCodeController::class, 'update'])->name('promocodesupdate');
    Route::post('promocodes.card/{id?}', [PromoCodeController::class, 'delete'])->name('promocodesdelete');
});

Auth::routes();
