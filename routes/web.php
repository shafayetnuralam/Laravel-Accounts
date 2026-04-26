<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\App;
Route::get('/', function () {
    return view('index');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/added', function () {
    return view('added');
  
});


Route::get('/test',[TestController::class,'index']);


Route::get('/store-session',[TestController::class,'storeSession']);
Route::get('/delete-session',[TestController::class,'deleteSession']);

Route::view('login','login')->name('login');
Route::view('register','register')->name('register');
Route::post('registerSave',[UserController:: class,'register'])->name('registerSave'); // register form action

Route::post('loginMatch',[UserController:: class,'login'])->name('loginMatch'); // login form action
Route::get('deshbord',[UserController:: class,'deshboradPage'])->name('deshbord'); // deshbord page
Route::get('deshbord/added',[UserController:: class,'addedPage'])->name('added'); // added page

Route::get('logout',[UserController:: class,'Logout'])->name('logout'); // logout page