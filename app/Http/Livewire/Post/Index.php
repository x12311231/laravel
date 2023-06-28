<?php

namespace App\Http\Livewire\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Request;

class Index extends Component
{
    public $query;

    public function mount(\Illuminate\Http\Request $request) {
        $query = $request->input('query');
        Log::debug('mount ' . $query);
        $this->query = $query;
    }

    public function render()
    {
        return view('livewire.post.index', [
            'posts' => Post::where('title', 'like', '%' . $this->query . '%')->paginate(10)
        ])->layout('components.layout');
    }

    public function search()
    {
        Log::debug('query' . $this->query);
        return $this->query;
    }
}
