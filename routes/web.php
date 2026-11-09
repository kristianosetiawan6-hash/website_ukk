<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1')->name('register.store');
});

Route::post('/guest', [AuthController::class, 'continueAsGuest'])->middleware('throttle:10,1')->name('guest.start');
Route::post('/guest/exit', [AuthController::class, 'exitGuest'])->name('guest.exit');

Route::get('/', function () {
    return view('payroll', [
        'currentUser' => auth()->user(),
        'isAdmin' => auth()->user()?->isAdmin() ?? false,
        'isGuest' => ! auth()->check(),
        'processedPayroll' => session('processedPayroll'),
    ]);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/payroll/process', [PayrollController::class, 'process'])
        ->middleware('role:admin')
        ->name('payroll.process');
});
