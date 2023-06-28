<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommonList extends Component
{
    public $items;

    public function render()
    {
        return view('livewire.common-list');
    }
}
