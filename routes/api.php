<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
// Route::post('/signup',[AccountController::class, 'signup']); 

Route::middleware(['log.requests'])->controller(AccountController::class)->group(function () {
    Route::post('signup','signUp');
    Route::post('login','logIn'); 
    Route::post('reset-password','resetPassword');
});

Route::middleware(['log.requests','token.validation'])->group(function(){


});