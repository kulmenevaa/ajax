<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DescController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('/fetch_left_block', [MainController::class, 'fetchLeftBlock'])->name('fetch_left_block');
Route::get('/fetch_right_block/{id?}', [MainController::class, 'fetchRightBlock'])->name('fetch_right_block');
Route::get('/save_right_block', [MainController::class, 'saveRightBlock'])->name('save_right_block'); 
Route::get('/save_right_block_by_user', [MainController::class, 'saveRightBlockByUser'])->name('save_right_block_by_user');
Route::get('/fetch_right_block_by_user', [MainController::class, 'fetchRightBlockByUser'])->name('fetch_right_block_by_user'); 
Route::get('/clear', [MainController::class, 'clear'])->name('clear');
Route::get('/delete_cart_user', [MainController::class, 'delete_cart_user'])->name('delete_cart_user');

Route::get('/desc', [DescController::class, 'index'])->name('desc');

Route::resource('users', UserController::class);
Route::get('/fetch-users', [UserController::class, 'fetchUsers'])->name('fetch_users');

Route::resource('directions', DirectionController::class);
Route::get('/fetch-directions', [DirectionController::class, 'fetchDirections'])->name('fetch_directions');

Route::resource('profiles', ProfileController::class);
Route::get('/fetch-profiles', [ProfileController::class, 'fetchProfiles'])->name('fetch_profiles');