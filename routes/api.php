<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JWTMiddleware;

Route::post('/user', 'App\Http\Controllers\UserController@store');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware([JWTMiddleware::class])->group(function () {
    Route::get('/user/{id}',[UserController::class,'show']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::delete('user/{id}', [AuthController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/search', [UserController::class, 'search']);
});
