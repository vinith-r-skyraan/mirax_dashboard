<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;


Route::get('/', fn() => redirect('/login'));

Route::get('/login', [AdminController::class, 'login'])
    ->name('login');

Route::post('/login', [AdminController::class, 'loginSubmit'])
    ->name('login.submit');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard.index');

    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('logout');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/blogs', [BlogController::class, 'index'])
        ->name('blogs.index');

    Route::get('/blogs/create', [BlogController::class, 'create'])
        ->name('blogs.create');

    Route::post('/blogs', [BlogController::class, 'store'])
        ->name('blogs.store');

    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])
        ->name('blogs.edit');

    Route::put('/blogs/{blog}', [BlogController::class, 'update'])
        ->name('blogs.update');

    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])
        ->name('blogs.destroy');
});