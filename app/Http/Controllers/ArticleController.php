<?php

namespace App\Http\Controllers;

use App\Events\NewArticle;
use App\Http\Requests\ArticleStoreRequest;
use App\Jobs\SyncMedia;
use App\Models\Article;
use App\Notification\ReviewNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store');
    }

    public function index(Request $request): View
    {
        $articles = Article::all();

        return view('article.index', compact('articles'));
    }

    public function show(Request $request, Article $article): Response
    {
        $article->increment('views');
        if ($article->save()) {
            Redis::zincrby(Article::REDIS_POPULAR_POSTS, 1, $article->id);
        }
        return \response($article);
//        $id = $article->id;
//        return $article = Article::find($id);
    }

    public function store(ArticleStoreRequest $request): RedirectResponse
    {
//        $request->merge(['author_id' => $request->user()->id]);
        $data = $request->validated();
        $article = Article::create(array_merge($data, ['author_id' => $request->user()->id]));

        Notification::send($article->author, new ReviewNotification($article));

        SyncMedia::dispatch($article);

        event(new NewArticle($article));

        $request->session()->flash('article.title', $article->title);

        return redirect()->route('article.index');
    }

    // 获取热门文章排行榜
    public function popular()
    {
        // 获取浏览器最多的前十篇文章
        $postIds = Redis::zrevrange(Article::REDIS_POPULAR_POSTS, 0, 9);
        if ($postIds) {
            $idsStr = implode(',', $postIds);
            // 查询结果排序必须和传入时的 ID 排序一致
            $posts = Article::whereIn('id', $postIds)
                ->select(['id', 'title', 'views'])
                ->orderByRaw('field(`id`, ' . $idsStr . ')')
                ->get();
        } else {
            $posts = null;
        }
//        dd($posts->toArray());
        return $posts;
    }
}
