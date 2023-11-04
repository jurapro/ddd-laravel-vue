<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('user/{user}', \App\Http\Controllers\Shared\User\GetUserController::class);
Route::get('users', \App\Http\Controllers\Shared\User\GetUsersController::class);

Route::get('auth/{user}', \App\Http\Controllers\Shared\User\AuthUserController::class);

Route::get('fact/{fact}', \App\Http\Controllers\PhpTop\Fact\GetFactController::class);
Route::get('facts', \App\Http\Controllers\PhpTop\Fact\GetRandomFactsController::class);

Route::get('test', function () {
    return view('test');
});
