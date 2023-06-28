<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PostForm extends Component
{
    public Post $post;



    protected $rules = [

        'post.title' => 'required|string|min:6',

        'post.content' => 'required|string|max:500',

    ];

    public function mount(Post $post)
    {
        $this->post = $post;
    }


    public function save(Request $request)

    {
        Log::debug('save');
        $this->validate();


        $this->post->user_id = User::firstOr(function () {
            return User::factory()->create();
        })->id;
        $this->post->save();

    }

    public function render()
    {
        return view('livewire.post-form')->layout('components.layout');
    }
}
