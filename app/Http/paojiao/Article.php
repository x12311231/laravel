<?php

namespace App\Http\paojiao;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Facades\Log;

class Article implements UrlRoutable
{
    const List = [
        [
            'title' => 'laravel',
            'content' => 'laravel is good'
        ],
        [
            'title' => 'vue',
            'content' => 'vue is good',
        ],
        [
            'title' => 'live wire',
            'content' => 'live wire is good',
        ]
    ];
    public $id;

    public $title;

    public $content;

    public function __construct()
    {
        Log::channel('laravel')
            ->debug('cccc ' . __CLASS__ . ' ' . __FUNCTION__ );
    }
//    public function __invoke($id)
//    {
//        // TODO: Implement __invoke() method.
//        Log::channel('laravel')
//            ->debug('cccc ' . __CLASS__ . ' ' . __FUNCTION__ );
//
//        return new self();
//    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }

    public function __toString()
    {
        return json_encode($this, 0);
    }
    public function resolveRouteBinding($value, $field = null)
    {
        $article = new self();
        if (array_key_exists($value, self::List)) {
            $article->id = $value;
            $article->title = self::List[$value]['title'];
            $article->content = self::List[$value]['content'];
//            return $article;
        }
        Log::channel('laravel')
            ->debug('cccc ' . __CLASS__ . ' ' . __FUNCTION__ . ' value：' . $value . ' class:' . json_encode($article));
        return $article;
    }

    public function getRouteKey()
    {
        Log::channel('laravel')
            ->debug('cccc ' . __CLASS__ . ' ' . __FUNCTION__ );
        // TODO: Implement getRouteKey() method.
    }

    public function getRouteKeyName()
    {
        Log::channel('laravel')
            ->debug('cccc ' . __CLASS__ . ' ' . __FUNCTION__ );
        // TODO: Implement getRouteKeyName() method.
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        Log::channel('laravel')
            ->debug('cccc ' . __CLASS__ . ' ' . __FUNCTION__ );
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
