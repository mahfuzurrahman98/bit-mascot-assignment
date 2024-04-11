<?php

use App\Mail\SendOTP;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('guest')->group(function () {
    // Signup
    Route::get('/signup', [UserController::class, 'create'])->name('signup');
    Route::post('/users/check', [UserController::class, 'checkUserExists'])->name('users.check');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

    // Login
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/email-verification', [AuthController::class, 'showEmailVerificationForm'])->name('email.form');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('email.verify');
});

Route::middleware('auth')->group(function () {
    // Admin
    Route::get('/admin', [UserController::class, 'index'])->name('users.index')->middleware('is_admin');

    // User
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('is_user');
    Route::get('/change-password', [AuthController::class, 'showPasswordForm'])->name('password.form')->middleware('is_user');
    Route::put('/password', [AuthController::class, 'updatePassword'])->name('password.update')->middleware('is_user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
