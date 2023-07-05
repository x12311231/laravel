<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormSearch extends Component
{

    protected $listeners = ['change' => 'change'];
    public $label;

    public $query = 'test query';

    public function render()
    {
        return view('livewire.form-search');
    }

    public function change($param) {
        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' param:' . $param);
    }

    public function submit()
    {
        $this->emit('change', $this->query);
    }

//    public function search() {
//        return $this->query;
//    }
}
