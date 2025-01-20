<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JWTMiddleware;

Route::post('/register', [UserController::class, 'store'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware([JWTMiddleware::class])->group(function () {
    Route::get('refresh-token', [AuthController::class, 'refreshToken'])->name('refresh');
    Route::get('user/{id}',[UserController::class,'show'])->name('user.show');
    Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('search', [UserController::class, 'search'])->name('search');
});
