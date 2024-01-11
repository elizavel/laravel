<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CashflowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProjectionController;
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

Route::controller(AccountController::class)->group(function () {
    Route::post('signup','signUp');
    Route::post('login','logIn'); 
    Route::post('reset-password','resetPassword');
});

Route::middleware(['log.requests','token.validation'])->controller(BudgetController::class)->group(function(){
    Route::post('budget/create','create');
    Route::get('budget/list/{id}','list');
    Route::get('budget/view/{id}','view');
    Route::post('budget/update','update'); 
    Route::delete('budget/delete/{id}','delete');
});

Route::middleware(['log.requests','token.validation'])->controller(IncomeController::class)->group(function(){
    Route::post('income/create','create');
    Route::get('income/list/{id}','list');
    Route::get('income/view/{id}','view');
    Route::post('income/update','update'); 
    Route::delete('income/delete/{id}','delete');
});

Route::middleware(['log.requests','token.validation'])->controller(BankAccountController::class)->group(function(){
    Route::post('bank-account/create','create');
    Route::get('bank-account/list/{id}','list');
    Route::get('bank-account/view/{id}','view');
    Route::post('bank-account/update','update'); 
    Route::delete('bank-account/delete/{id}','delete');
}); 

Route::middleware(['log.requests','token.validation'])->controller(GoalController::class)->group(function(){
    Route::post('goal/create','create');
    Route::get('goal/list/{id}','list');
    Route::get('goal/view/{id}','view');
    Route::post('goal/update','update'); 
    Route::delete('goal/delete/{id}','delete');
}); 

Route::middleware(['log.requests','token.validation'])->controller(CashflowController::class)->group(function(){
    Route::post('cashflow/create','create');
    Route::get('cashflow/list/{id}','list');
    Route::get('cashflow/view/{id}','view');
    Route::post('cashflow/update','update'); 
    Route::delete('cashflow/delete/{id}','delete');
}); 

Route::middleware(['log.requests','token.validation'])->controller(DeductionController::class)->group(function(){
    Route::post('deduction/create','create');
    Route::get('deduction/list/{id}','list');
    Route::get('deduction/view/{id}','view');
    Route::post('deduction/update','update'); 
    Route::delete('deduction/delete/{id}','delete');
});

Route::middleware(['log.requests','token.validation'])->controller(PeriodController::class)->group(function(){
    Route::post('period/create','create');
    Route::get('period/list','list');
    Route::get('period/view/{id}','view');
    Route::post('period/update','update'); 
    Route::delete('period/delete/{id}','delete');
});

Route::middleware(['log.requests','token.validation'])->controller(CategoryController::class)->group(function(){
    Route::post('category/create','create');
    Route::get('category/list','list');
    Route::get('category/view/{id}','view');
    Route::post('category/update','update'); 
    Route::delete('category/delete/{id}','delete');
});



//todo
Route::middleware(['log.requests','token.validation'])->controller(ProjectionController::class)->group(function(){
    Route::post('projection/create','create');
    Route::get('projection/list/{id}','list');
    Route::get('projection/view/{id}','view');
    Route::post('projection/update','update'); 
    Route::delete('projection/delete/{id}','delete');
});

Route::middleware(['log.requests','token.validation'])->controller(ContributionController::class)->group(function(){
    Route::post('contribution/create','create');
    Route::get('contribution/list/{id}','list');
    Route::get('contribution/view/{id}','view');
    Route::post('contribution/update','update'); 
    Route::delete('contribution/delete/{id}','delete');
});