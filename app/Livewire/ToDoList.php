<?php

namespace App\Livewire;

use App\Models\ToDo;
use Livewire\Component;

class ToDoList extends Component
{
    public $todos;

    public function mount() {
        $this->todos = ToDo::all();
    }
    
    public function render()
    {
        return view('livewire.to-do-list');
    }
}
