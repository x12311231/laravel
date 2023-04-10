<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function show($id)
    {
//        $post = QueryBuilder::for(Post::class)
//            ->findOrFail($id);
        $post = Post::find($id);
        return PostResource::make($post);
//        return $post;
    }

    public function index()
    {
//        $posts = Post::with(['author', 'comments'])
//            ->paginate();
        $posts = QueryBuilder::for(Post::class)
            ->allowedIncludes(['author', 'comments'])
            ->paginate();
//        return $posts;
        return PostResource::collection($posts);
    }
}
