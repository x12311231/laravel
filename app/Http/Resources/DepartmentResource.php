<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class DepartmentResource extends JsonApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
//    public function toArray(Request $request): array
//    {
//        return parent::toArray($request);
//    }
        public function toRelationships(Request $request)
        {
            return [
                'employees' => fn() => EmployeeResource::collection($this->employees)
            ];
        }
//        public $relationships = [
//            'employees' => EmployeeResource::class
//        ];
}
