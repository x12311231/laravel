<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class UserResource extends JsonApiResource
{
    public $attributes = [
        'name'
    ];
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }
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
