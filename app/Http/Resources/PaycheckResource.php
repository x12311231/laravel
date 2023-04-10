<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TiMacDonald\JsonApi\JsonApiResource;

class PaycheckResource extends JsonApiResource
{
//    /**
//     * Transform the resource into an array.
//     *
//     * @return array<string, mixed>
//     */
//    public function toArray(Request $request): array
//    {
//        return parent::toArray($request);
//    }
    public function toRelationships($request): array
    {
        return [
            'employee' => fn() => EmployeeResource::make($this->employee)
        ];
    }
//    public function toAttributes($request): array
//    {
//        return [
//            'amount' => Amount::from($this->net_amount)->toArray(),
//            'payed_at' => $this->payed_at,
//        ];
//    }

    public function toId(Request $request): string
    {
        return $this->uuid;
    }
}
