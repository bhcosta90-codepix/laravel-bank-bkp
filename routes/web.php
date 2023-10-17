<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/counter', App\Livewire\Counter::class);

Route::middleware('auth:accounts')->group(function(){
    Route::get('/home', App\Livewire\Counter::class)->name('home');
});

Route::get('/account/login', App\Livewire\Account\Login::class)->name('login');
Route::get('/account/register', App\Livewire\Account\Register::class)->name('register');

