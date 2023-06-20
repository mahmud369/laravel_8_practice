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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users-list', [App\Http\Controllers\HomeController::class, 'users_list'])->name('users-list');
Route::post('/save-file', [App\Http\Controllers\HomeController::class, 'save_file'])->name('save-file');
Route::get('/delete-file/{id}', [App\Http\Controllers\HomeController::class, 'delete_file'])->name('delete-file');
