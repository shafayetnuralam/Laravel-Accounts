<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TestUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
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

// // deshbord page
// Route::get('deshbord',[UserController:: class,'deshboradPage'])
// ->name('deshbord')
// ->middleware(['LsValidUser:admin,user',TestUser::class]); // deshbord page with middleware

// // added page 
// Route::get('deshbord/added',[UserController:: class,'addedPage'])
// ->name('added')
// ->middleware(['LsValidUser:admin',TestUser::class]); // added page with middleware


// deshbord page
Route::get('deshbord',[UserController:: class,'deshboradPage'])
->name('deshbord')
->middleware(["auth",'LsValidUser:admin']); // deshbord page with middleware

// added page 
Route::get('added',[UserController:: class,'addedPage'])
->name('added')
->middleware(["auth",'LsValidUser:admin']); // deshbord page with middleware



// Route::middleware(['ok-user'])->group(function () {
//     Route::get('deshbord',[UserController:: class,'deshboradPage'])
//     ->name('deshbord'); // deshbord page with middleware
//     // deshbord page 
//     Route::get('deshbord/added',[UserController:: class,'addedPage'])
//     ->name('added')->withoutMiddleware(TestUser::class); // added page with middleware
// });




Route::get('logout',[UserController:: class,'Logout'])->name('logout'); // logout page