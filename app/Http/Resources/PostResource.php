<?php

namespace App\Http\Resources;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class PostResource extends JsonApiResource
{
//    protected Model $model;
    protected Model $model;
    public function __construct(Post $resource)
    {
        $this->model = $resource;
        parent::__construct($resource);
    }

    public array $attributes = [
        'title',
        'content'
    ];
    /**
     * @var array|string[]
     */
    public array $relationships = [
        'author' => UserResource::class,
        'comments' => CommentResource::class
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
//    public function toArray(Request $request): array
//    {
//        return parent::toArray($request);
//    }

}
