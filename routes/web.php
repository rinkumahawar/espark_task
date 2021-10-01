<?php

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/clear', function() {
    
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('clear-compiled');
    return 'DONE'; 
  });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/post-list', [App\Http\Controllers\HomeController::class, 'PostList'])->name('PostList');
Route::get('/add-post', [App\Http\Controllers\HomeController::class, 'AddPost'])->name('AddPost');
Route::post('/StorePost', [App\Http\Controllers\HomeController::class, 'StorePost'])->name('StorePost');
Route::get('/edit-post/{id}', [App\Http\Controllers\HomeController::class, 'AddPost'])->name('EditPost');
Route::get('/delete-post/{id}', [App\Http\Controllers\HomeController::class, 'DeletePost'])->name('DeletePost');
Route::get('/post/{id}', [App\Http\Controllers\HomeController::class, 'ViewPost'])->name('ViewPost');
Route::post('/PostLike', [App\Http\Controllers\HomeController::class, 'PostLike'])->name('PostLike');
Route::post('/PostComment/{id}', [App\Http\Controllers\HomeController::class, 'PostComment'])->name('PostComment');
Route::post('/CommentReply/{id}', [App\Http\Controllers\HomeController::class, 'CommentReply'])->name('CommentReply');
Route::get('/DeleteComment/{id}/{type}', [App\Http\Controllers\HomeController::class, 'DeleteComment'])->name('DeleteComment');
