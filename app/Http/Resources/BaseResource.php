<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

abstract class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * @throws \Exception
     */
    public function show($id)
    {
//        return '1111';
//        return $this->post->find(1);
        $data = $this->model::where(['id' => $id])->with(['author', 'comments'])->get();
        if ($data->isEmpty()) {
            throw new NotFoundHttpException("posts not found");
        }
        return $data;
    }

    public function index(Request $request)
    {
        return $this->model::limit(10)->get();
    }
}
