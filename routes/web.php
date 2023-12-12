<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\GameController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    // return view('login_page');
    return redirect('/login');
});

// Route::get('/callback', [GameController::class, 'handle']);
Route::get('/res/gameList', [GameController::class, 'gameList']);
Route::get('/res/bettingList', [GameController::class, 'bettingList']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
