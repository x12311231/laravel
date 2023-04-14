<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class NewArticle
{
    use SerializesModels;

    public $article;

    /**
     * Create a new event instance.
     */
    public function __construct($article)
    {
        $this->article = $article;
    }
}
