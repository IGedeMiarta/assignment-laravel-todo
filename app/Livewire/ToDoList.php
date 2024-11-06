<?php

namespace App\Livewire;

use Livewire\Component;

class ToDoList extends Component
{
    public $todos;

    public function mount() {
        $this->todos = auth()->user()->todos;
    }
    
    public function render()
    {
        return view('livewire.to-do-list');
    }
}
