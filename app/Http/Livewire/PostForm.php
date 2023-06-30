<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Livewire;

class PostForm extends Component
{
    public Post $post;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [

        'post.title' => 'required|string|min:6',

        'post.content' => 'required|string|max:500',

    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        Livewire::listen('PostForm.hydrate', function ($component, $request) {
            Log::channel('laravel')
                ->debug('component.hydrate' . var_export($component, true) . var_export($request, true));
        });
    }


    public function save(Request $request)

    {
        Log::debug('save');
        $this->validate();


        $this->post->user_id = User::firstOr(function () {
            return User::factory()->create();
        })->id;
        if ($this->post->save()) {
            $this->emit('refresh');
        }

    }

    public function render()
    {
        return view('livewire.post-form')->layout('components.layout');
    }

    public function updating($name, $value)
    {
        Log::debug('default updating');
        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' name:' . $name . ' value:' . $value);
    }



    public function updated($name, $value)
    {

        Log::channel('laravel')
            ->debug(__CLASS__ . ' ' . __FUNCTION__ . ' name:' . $name . ' value:' . $value);
        //
        $this->validateOnly($name);
    }
}
