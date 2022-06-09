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
   // 'prefix' => 'auth',

 ], function($router){

   route::prefix('auth')->group(function(){
     Route::post('login',[AuthController::class, 'login'])->name('login');
     Route::post('register',[AuthController::class, 'register'])->name('register');
     Route::POST('me', [AuthController::class, 'me'])->name('me');
     Route::POST('refresh',[AuthController::class, 'refresh'])->name('refresh');
     Route::POST('logout',[AuthController::class, 'logout'])->name('logout');
   });

   route::apiResource('forum', 'ForumController');

});
