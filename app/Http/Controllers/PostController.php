<?php

namespace App\Http\Controllers;

use App\Events\NewPost;
use App\Http\Requests\PostStoreRequest;
use App\Jobs\SyncMedia;
use App\Mail\ReviewPost;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function create(Request $request): View
    {
        Log::debug('post create view');
        return view('post.create');
    }

    public function show(Request $request, Post $post): View
    {
        return view('post.show', compact('post'));
    }

    public function index(Request $request): View
    {
        Log::debug('post index view');
        $posts = Post::all();
        foreach ($posts as $k => &$v) {
            $v->content = Str::words($v->content, 5, '...');
            $v->url = \route('post.show', ['post' => $v->id]);
        }

        return view('post.index', compact('posts'));
    }

    public function store(PostStoreRequest $request): RedirectResponse
    {
//        return 'ok';
        Log::debug('test post store');
//        $request->merge(['author_id' => $request->user()->id]);
//        $request->fullUrlWithQuery(['author_id' => $request->user()->id]);
//        $data['author_id' => $request->user()->id];
        DB::transaction(function () use ($request) {
            $post = Post::create(array_merge($request->validated(), ['author_id' => $request->user()->id]));

//            Mail::to($post->author->email)->send(new ReviewPost($post));

            $image = $request->file('image');

            $imgName = $image->getFilename() . '.' . (new \SplFileInfo($image->getClientOriginalName()))->getExtension();
//            $imgName = $image->name;
            $content = base64_encode($image->getContent());
            SyncMedia::dispatch($post, $imgName, $content);

            event(new NewPost($post));

            $request->session()->flash('post.title', $post->title);
        });

//        return $post;
        return redirect()->route('post.index');
    }
}
