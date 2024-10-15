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
    // public function delete(Todo $todo){
    //         $todo->delete();
    //     } or

    public function delete($todoId){
        Todo::find($todoId)->delete();
    }

    public function toggle($todoId){
        $todo = Todo::find($todoId);
        $todo->comleted = !$todo->comleted;
        $todo->save();

    }
    public function render()
    {

        return view('livewire.todo-list',[
            'todos' => Todo::latest()
            ->where('name','like',"%{$this->search}%")
            ->paginate(5)
        ]);
    }
}
