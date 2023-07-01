<?php

namespace App\Http\Livewire;

use App\Http\paojiao\Article;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class User extends Component
{

    public $name = '';

    public $article = [];

    public function __construct($id = null)
    {
        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' article:' . json_encode($this->article));
        parent::__construct($id);
    }

    public function mount(Article $article) {
        Log::channel('laravel')
            ->debug('mount article :' . json_encode($article));
        $this->article = (array)$article;
    }



    protected $rules = [
        'name' => 'required|string|min:6'
    ];

    public function render()
    {
        return view('livewire.user')->layout('components.layout');
    }

    public function submit()
    {
        $this->validate();
        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' ' . $this->name . ' article: ' . json_encode($this->article) . ' type:' . ($this->article instanceof Article ? $this->article::class : var_export($this->article, true)));
        return 'ok';
    }

    public function updated($name, $value)
    {

        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' name:' . $name . ' value:' . $value);
        //
        $this->validateOnly($name);
    }
}
