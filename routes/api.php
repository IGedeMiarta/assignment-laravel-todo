<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/todo', [ToDoController::class, 'index']);
    Route::post('/todo', [ToDoController::class, 'store']);
    Route::get('/todo/{id}', [ToDoController::class, 'show']);
    Route::put('/todo/{id}', [ToDoController::class, 'update']);
    Route::delete('/todo/{id}', [ToDoController::class, 'destroy']);
});
