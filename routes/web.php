<?php

use App\Http\Controllers\PaymentController;
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


// paymentView
// Route::get('paymentView',[UserController:: class,'paymentView'])
// ->name('paymentView')
// ->middleware(["auth",'LsValidUser:admin']); // payment view page with middleware

// Route::middleware(['ok-user'])->group(function () {
//     Route::get('dashboard',[UserController:: class,'deshboradPage'])
//     ->name('dashboard'); // dashboard page with middleware
//     // dashboard page 
//     Route::get('dashboard/added',[UserController:: class,'addedPage'])
//     ->name('added')->withoutMiddleware(TestUser::class); // added page with middleware
// });


// Account Routes
Route::middleware(['auth', 'LsValidUser:admin'])->group(function () {
    // Account routes
    Route::get('accountSetupView', [UserController::class, 'accountSetupView'])->name('accountSetupView');
    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::post('accounts/data', [AccountController::class, 'getAccountsData'])->name('accounts.data');
    Route::post('accounts/check-duplicate', [AccountController::class, 'checkDuplicate'])->name('accounts.check-duplicate');
    Route::get('accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::get('accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::put('accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');

    // Receive routes
    Route::get('receiveView', [UserController::class, 'receiveView'])->name('receiveView');
    Route::post('receives/data', [ReceiveController::class, 'getReceivesData'])->name('receives.data');
    Route::post('receives/check-duplicate', [ReceiveController::class, 'checkDuplicate'])->name('receives.check-duplicate');
    Route::get('receives/create', [ReceiveController::class, 'create'])->name('receives.create');
    Route::post('receives', [ReceiveController::class, 'store'])->name('receives.store');
    Route::get('receives/{id}/edit', [ReceiveController::class, 'edit'])->name('receives.edit');
    Route::put('receives/{id}', [ReceiveController::class, 'update'])->name('receives.update');
    Route::delete('receives/{id}', [ReceiveController::class, 'destroy'])->name('receives.destroy');
    Route::get('receives/last-invoice', [ReceiveController::class, 'getLastInvoice'])->name('receives.getLastInvoice');

    // Payment routes
    Route::get('paymentView', [UserController::class, 'paymentView'])->name('paymentView');
    Route::post('payments/data', [PaymentController::class, 'getPaymentsData'])->name('payments.data');
    Route::post('payments/check-duplicate', [PaymentController::class, 'checkDuplicate'])->name('payments.check-duplicate');
    Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
    Route::delete('payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('payments/last-invoice', [PaymentController::class, 'getLastInvoice'])->name('payments.getLastInvoice');

});


Route::get('logout',[UserController:: class,'Logout'])->name('logout'); // logout page