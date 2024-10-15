<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;
    public $search;
    public function create(){
        // dd('test');

        // validate
        $validdated = $this->validateOnly('name');
        // create the tabel
        Todo::create($validdated); //we must add this protected $guarded =[]; to the TodoList model
        // clear the input
        $this->reset('name');
        // send flash message
        session()->flash('success','Created');
    }

    public function render()
    {

        return view('livewire.todo-list',[
            'todos' => Todo::latest()->paginate(3)
        ]);
    }
}
