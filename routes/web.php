<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth')->name('profile');

Route::post('/register', [HomeController::class, 'register'])->name('register');
Route::post('/login', [HomeController::class, 'login'])->name('login');
Route::get('/tbot', [HomeController::class, 'tbot'])->name('tbot');
Route::get('/sendmsg', [HomeController::class, 'sendmsg'])->name('sendmsg');


Route::match(['get', 'post'], '/botman', [HomeController::class, 'handle']);

// get the chat id and update in db
Route::get('5100943662:AAG362wrOfZJjoXvOcvkyrxJ9-t2QTz-Wes/webhook', [HomeController::class, 'configtelegram']);