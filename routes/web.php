<?php

use App\Livewire\ToDoList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->intended('/api/documentation');
});
Route::get('/todo',ToDoList::class)->name('todos');
