<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FormInput extends Component
{
    public $name;
    public $label;
    public $placeholder = 'placeholder';
    public $value;

    public function render()
    {
        return view('livewire.form-input');
    }
}
