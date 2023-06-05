<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\IntroController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//protected
Route::post('/forgetpassword', [AuthController::class, 'forgetpassword']);

Route::apiResource('notifications', NotificationController::class);


//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('showintros', [IntroController::class, 'index']);
    //temp
    Route::post('addintros', [IntroController::class, 'store']);
    //end temp
    Route::get('showcategories', [CategoryController::class, 'index']);
    Route::get('showshops', [ShopController::class, 'index']);
    Route::post('addreport', [ReportController::class, 'store']);
    Route::post('addblock', [BlockController::class, 'store']);
    Route::get('showfavorites', [FavoriteController::class, 'index']);
    Route::post('addfavorite', [FavoriteController::class, 'store']);
    Route::apiResource('products', ProductController::class);
    Route::get('/products/search/{title}', [ProductController::class, 'search']);
    Route::post('/changepassword', [AuthController::class, 'changepassword']);
    Route::post('/editprofile', [AuthController::class, 'editprofile']);
    Route::post('/logout', [AuthController::class, 'logout']);


});
