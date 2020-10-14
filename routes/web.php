<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/threads', [App\Http\Controllers\ThreadsController::class, 'index'])->name('threads.index');

Route::post('/threads', [App\Http\Controllers\ThreadsController::class, 'store'])->name('threads.store');

Route::get('/threads/{thread}', [App\Http\Controllers\ThreadsController::class, 'show'])->name('threads.show');

Route::post('/threads/{thread}/replies', [App\Http\Controllers\RepliesController::class, 'store'])->name('replies.store');
