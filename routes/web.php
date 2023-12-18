<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;


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

Route::post('/gamelist', [HomeController::class, 'loginCheck'])->name('gamelist');


// Route::get('/callback', [GameController::class, 'handle']);
// Route::get('/res/gameList', [GameController::class, 'gameList']);
// Route::get('/res/bettingList', [GameController::class, 'bettingList']);
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/res/gameList', [GameController::class, 'gameList']);
    Route::get('/res/bettingList', [GameController::class, 'bettingList']);
    Route::get('/launch_game/{id}/{vender}', [GameController::class, 'launch_game'])->name('launch_game');
    // Route::post('/get_game_data', [GameController::class, 'get_data']);
    Route::get('res/charge' , [GameController::class, 'charge'])->name('charge');
    Route::post('res/add_charge' , [GameController::class, 'add_charge'])->name('add_charge');

    Route::get('res/exchange' , [GameController::class, 'exchange'])->name('exchange');
    Route::post('res/add_exchange' , [GameController::class, 'add_exchange'])->name('sub_balance');


});
