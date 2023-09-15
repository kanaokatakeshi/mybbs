<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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
    return redirect(route('login'));
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    // ホーム
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // プロフィール
    Route::get('/profile', [HomeController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [HomeController::class, 'update'])->name('profile.update');

    // 投稿
    Route::resource('post', PostController::class);

    // コメント
    Route::resource('comment', CommentController::class);
});
