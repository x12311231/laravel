<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
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

    public function mount()
    {
        $this->value = Carbon::now()->toString();
    }
}
