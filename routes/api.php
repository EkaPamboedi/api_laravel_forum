<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
// use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;


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
    
    Route::GET('user/@{username}',[UserController::class, 'show']);
    
    Route::GET('forum/tag/{tag}',[ForumController::class, 'FilterTag'])->name('FilterTag');
   
   route::apiResource('forum', 'ForumController');
   route::apiResource('forum.comments', 'ForumCommentController');
   //forums/{id_forum}/comments/{id_comment}
});
