<?php

use App\Http\Controllers\BlogController;
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

//Auth routes
Route::get('login', [\App\Http\Controllers\AuthController::class, 'getLogin'])->name('login');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::group(['middleware'=>['auth:web']],function (){
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index')->middleware('role:Admin');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


