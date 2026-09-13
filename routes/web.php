<?php

use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['auth', 'force.password.change'])->group(function () {
    Route::get('/', function () {
        return view('home.index');
    })->name('home');

    Route::resource('users', UsersController::class)->middleware('role:admin');

    Route::get('/profile', [ProfilesController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfilesController::class, 'update'])->name('profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/password-change', [AuthController::class, 'changePassword'])->name('new-user');
    Route::post('/password-change', [AuthController::class, 'updatePassword'])->name('password-change');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('guest')->group(function () {
   Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
   Route::get('/login', function () {
       return view('auth.login');
   })->name('login');
   Route::get('/new-user-confirmation/{token}', [AuthController::class, 'newUserConfirmation'])->name('users.confirm');
});
