<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('index');
});

Route::resource('products', ProductController::class);
Route::get('login', [UserController::class, 'login' ]);
Route::post('checkLogin', [UserController::class, 'checkLogin' ]);
Route::get('logout', [UserController::class, 'logout' ]);
Route::fallback(function () {
    return view('404');
});
