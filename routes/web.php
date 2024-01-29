<?php

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

// login
Route::get('/', App\Livewire\Auth\Login::class)->name('login');

Route::middleware(['auth'])->group(function () {
    // logout
    Route::get('/logout', App\Livewire\Auth\Logout::class)->name('logout');

    // dashboard
    Route::get('/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard.index');

    Route::group(['middleware' => ['role:developer']], function () {
        Route::get('/setting/user', App\Livewire\Admin\Setting\User::class)->name('admin.setting.user');
    });

});
