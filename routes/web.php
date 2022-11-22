<?php

use App\Http\Controllers\ChatController;
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
    return view('chat');
});
Route::get('chat', [ChatController::class,'chat'])->name('chat');
Route::post('send', [ChatController::class,'send']);
Route::post('store-register-user', [\App\Http\Controllers\Auth\LoginController::class,'authenticated']);
Route::post('register-user', [\App\Http\Controllers\Auth\RegisterController::class,'registered']);

Route::post('saveToSession',[ChatController::class,'saveToSession']);
Route::post('deleteSession',[ChatController::class,'deleteSession']);
Route::post('getOldMessage',[ChatController::class,'getOldMessage']);
Route::get('check',function(){
    return session('chat');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
