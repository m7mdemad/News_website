<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use vendor\laravel\ui\stubs\Auth;
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

Route::group(['middleware' => ['web']], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
});


// forget password
//Route::post('forget', 'ForgotPasswordController@getResetToken');

//reset password
//Route::get('password/reset', 'C:\Users\H S\Desktop\News_website\vendor\laravel\ui\stubs\Auth\ResetPasswordController@reset')->name('password.reset');;

//user verification
//Route::get('email/verify/{token}', 'Auth\VerificationController@verify');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
