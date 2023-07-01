<?php

namespace App\Http\Livewire;

use Livewire\Component;

class User1 extends Component
{
    public $name;
    public $age;

    public $email;

    public function render()
    {
        return view('livewire.user1')->layout('components.layout');
    }
}
