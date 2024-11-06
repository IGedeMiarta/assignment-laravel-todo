<?php

use App\Livewire\ToDoList;
use Illuminate\Support\Facades\Route;

Route::get('/todos',ToDoList::class)->name('todos');
