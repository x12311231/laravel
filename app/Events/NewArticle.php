<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewArticle implements ShouldBroadcastNow
{
    use SerializesModels;
    use Dispatchable;

    public $article;

    /**
     * Create a new event instance.
     */
    public function __construct($article)
    {
        $this->article = $article;
    }

    public function broadcastOn()
    {
        // TODO: Implement broadcastOn() method.
        return [
            new Channel('article.' . $this->article->author_id),
            new PrivateChannel('private.article.' . $this->article->author_id),
        ];
    }
}
