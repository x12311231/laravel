<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index1 extends Component
{
    use WithPagination;

    public $query;

    public $contentIsVisible;

    public function toggleContent()
    {
        $this->contentIsVisible = !$this->contentIsVisible;
    }

    public function render()
    {
        $posts = Post::where('title', 'like', '%' . $this->query . '%')->paginate(10);
        return view('livewire.post.index1', ['posts' => $posts])->layout('components.layout');
    }
}
