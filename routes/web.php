<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\IntroController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');

// });
Route::get('/', function () {
    return view('admin.parent');
});

Route::get('parent', function () {
    return view('admin.parent');
})->name('admin.parent');

// Route::get('showusers', function () {
//     return view('admin.users.index');
// })->name('users.index');

Route::resource('user', UserController::class);
Route::resource('category', ControllersCategoryController::class);
Route::resource('intro', IntroController::class);
Route::resource('product', ProductController::class);
Route::resource('report', ReportController::class);
Route::resource('shop', ShopController::class);
Route::resource('favorite', FavoriteController::class);
Route::resource('block', BlockController::class);

