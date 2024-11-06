<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/todos', [ToDoController::class, 'index']);
    Route::post('/todos', [ToDoController::class, 'store']);
    Route::get('/todos/{id}', [ToDoController::class, 'show']);
    Route::put('/todos/{id}', [ToDoController::class, 'update']);
    Route::delete('/todos/{id}', [ToDoController::class, 'destroy']);
});
