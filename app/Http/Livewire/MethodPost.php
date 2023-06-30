<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MethodPost extends Component
{
    public $str;


    protected $rules = [
        'str' => 'required|string|min:6'
    ];

    public function render()
    {
        return view('livewire.method-post');
    }

    public function submit()
    {
        $this->validate();
        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $this->str);
        return 'ok';
    }
}
