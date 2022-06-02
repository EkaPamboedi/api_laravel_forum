<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;


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
Route::group([
  'middleware' => 'api',
   'prefix' => 'auth',

 ], function($router){
  Route::post('login',[AuthController::class, 'login'])->name('login');
  Route::post('register',[AuthController::class, 'register'])->name('register');
  // Route::POST('refresh',[AuthController::class, 'refresh'])->name('refresh');
  // Route::POST('me', [AuthController::class, 'me'])->name('me');
  // Route::POST('logout',[AuthController::class, 'logout'])->name('logout');

    // Route::post('register', 'AuthController@register');
    // Route::post('login', 'AuthController@login');
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');


});
