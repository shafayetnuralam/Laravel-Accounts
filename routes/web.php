<?php

use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TestUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\ValidUser;

Route::get('/', function () {
    return view('index');
});

Route::get('/blank', function () {
    return view('blank');
})->name('blank');


Route::get('/test',[TestController::class,'index']);


// Route::get('/store-session',[TestController::class,'storeSession']);
// Route::get('/delete-session',[TestController::class,'deleteSession']);

Route::view('login','login')->name('login');
Route::view('register','register')
->name('register'); // register page
Route::post('registerSave',[UserController:: class,'register'])->name('registerSave'); // register form action

Route::post('loginMatch',[UserController:: class,'login'])->name('loginMatch'); // login form action

// // dashboard page
// Route::get('dashboard',[UserController:: class,'deshboradPage'])
// ->name('dashboard')
// ->middleware(['LsValidUser:admin,user',TestUser::class]); // dashboard page with middleware

// // added page 
// Route::get('dashboard/added',[UserController:: class,'addedPage'])
// ->name('added')
// ->middleware(['LsValidUser:admin',TestUser::class]); // added page with middleware


// dashboard page
Route::get('dashboard',[UserController:: class,'deshboradPage'])
->name('dashboard')
->middleware(["auth",'LsValidUser:admin']); // dashboard page with middleware

// added page 
Route::get('added',[UserController:: class,'addedPage'])
->name('added')
->middleware(["auth",'LsValidUser:admin']); // dashboard page with middleware


// added page 
Route::get('accountSetupView',[UserController:: class,'accountSetupView'])
->name('accountSetupView')
->middleware(["auth",'LsValidUser:admin']); // dashboard page with middleware

// receiveView 
Route::get('receiveView',[UserController:: class,'receiveView'])
->name('receiveView')
->middleware(["auth",'LsValidUser:admin']); // receive view page with middleware

// Route::middleware(['ok-user'])->group(function () {
//     Route::get('dashboard',[UserController:: class,'deshboradPage'])
//     ->name('dashboard'); // dashboard page with middleware
//     // dashboard page 
//     Route::get('dashboard/added',[UserController:: class,'addedPage'])
//     ->name('added')->withoutMiddleware(TestUser::class); // added page with middleware
// });




// Account Routes
Route::middleware(['auth', 'LsValidUser:admin'])->group(function () {
    Route::post('accounts/data', [AccountController::class, 'getAccountsData'])->name('accounts.data');
    Route::post('accounts/check-duplicate', [AccountController::class, 'checkDuplicate'])->name('accounts.check-duplicate');
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::get('accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::put('accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');
});

Route::middleware(['auth','LsValidUser:admin'])->group(function () {
    Route::post('receives/data', [ReceiveController::class, 'getReceivesData'])->name('receives.data');
    // Other receive routes can be added here
});

Route::get('logout',[UserController:: class,'Logout'])->name('logout'); // logout page