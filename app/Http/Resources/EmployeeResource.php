<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class EmployeeResource extends JsonApiResource
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

    public function toAttributes($request): array
    {
        return [
            'name' => $this->full_name,
            'email' => $this->email,
            'job_title' => $this->job_title,
            'payment' => [
                'type' => $this->payment_type->type(),
                'amount' => $this->payment_type->amount(),
            ],
        ];
    }

    public function toId(Request $request)
    {
        return $this->uuid;
    }
}
