<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormSearch extends Component
{

    public $label;

    public $query = 'test query';

    public function render()
    {
        return view('livewire.form-search');
    }

//    public function search() {
//        return $this->query;
//    }
}
