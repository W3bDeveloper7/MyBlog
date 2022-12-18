<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
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
    //
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index')->middleware('role:Admin');
    Route::get('/', [BlogController::class, 'getBlogs'])->name('home');
    Route::get('/list-blogs', [BlogController::class, 'getBlogsDT'])->name('blogs.list');
    Route::get('/list-blog/{blog}', [BlogController::class, 'show'])->name('blogs.show');
    Route::post('blogs', [BlogController::class, 'store'])->name('blogs.store')->middleware('role:Admin');;

    //Users Routes
    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('role:Admin');
    Route::get('/list-user/{user}', [UserController::class, 'show'])->name('users.show')->middleware('role:Admin');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
});




