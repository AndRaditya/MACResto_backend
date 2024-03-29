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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::get('email/verify/{id}', 'Api\VerificationController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'Api\VerificationController@resend')->name('verificationapi.resend');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::post('user', 'Api\UserController@store');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');

    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::post('user', 'Api\UserController@store');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');

    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::post('user', 'Api\UserController@store');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');

    Route::post('logout', 'Api\AuthController@logout');

    Route::get('review', 'Api\ReviewController@index');
    Route::get('review/{id}', 'Api\ReviewController@show');
    Route::post('review', 'Api\ReviewController@store');
    Route::put('review/{id}', 'Api\ReviewController@update');
    Route::delete('review/{id}', 'Api\ReviewController@destroy');

    Route::get('reservation', 'Api\ReservationController@index');
    Route::get('reservation/{id}', 'Api\ReservationController@show');
    Route::post('reservation', 'Api\ReservationController@store');
    Route::put('reservation/{id}', 'Api\ReservationController@update');
    Route::delete('reservation/{id}', 'Api\ReservationController@destroy');

    Route::get('order', 'Api\OrderController@index');
    Route::get('order/{id}', 'Api\OrderController@show');
    Route::post('order', 'Api\OrderController@store');
    Route::put('order/{id}', 'Api\OrderController@update');
    Route::delete('order/{id}', 'Api\OrderController@destroy');
});
