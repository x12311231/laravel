<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public $post;

    public function mount(Post $post)
    {
        Log::channel('laravel')
            ->debug('mount post :' . $post);
        $this->post = $post;
    }
    public function render()
    {
        return view('livewire.post.show', ['post' => $this->post])->layout('components.layout');
    }
}
