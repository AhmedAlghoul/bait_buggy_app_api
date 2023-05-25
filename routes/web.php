<?php

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

Route::get('showusers', function () {
    return view('admin.users.index');
})->name('users.index');
