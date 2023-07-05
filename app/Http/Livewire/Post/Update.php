<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;

class Update extends Component
{
    public Post $post;



    protected $rules = [

        'post.title' => 'required',

    ];



    public function update()

    {

        $this->validate();



        $this->post->save();



        sleep(2);
        if (rand(0, 3) > 2) {
            1/0;
        }
        session()->flash('message', 'Post successfully updated.');

    }
    public function render()
    {
        return view('livewire.post.update')->layout('components.layout');
    }
}
