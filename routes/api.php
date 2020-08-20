<?php

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

Route::group(
    ['prefix' => 'auth',],
    static function () {
        /**
         * @see UserController::login()
         */
        Route::post('login', 'UserController@login')->name('login');
        /**
         * @see UserController::register()
         */
        Route::post('register', 'UserController@register');

        Route::group(
            ['middleware' => 'auth:api'],
            static function () {
                /**
                 * @see UserController::logout
                 */
                Route::get('logout', 'UserController@logout');
                /**
                 * @see UserController::user
                 */
                Route::get('user', 'UserController@user');
            }
        );
    }
);
/**
 * @see \App\Http\Controllers\CategoryController
 */
Route::apiResource('categories', 'CategoryController');
/**
 * @see \App\Http\Controllers\ProductController
 */
Route::apiResource('products', 'ProductController');
/**
 * @see \App\Http\Controllers\CategoryController::showProducts()
 */
Route::get('categories/{category}/products', 'CategoryController@showProducts')->name('categories.showproducts')->where(
    ['category' => '[0-9]+']
);
