<?php

namespace App\Presentation\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => method_exists($this->resource, 'getId')
                ? $this->resource->getId()
                : $this->resource->id,
            'name' => method_exists($this->resource, 'getName')
                ? $this->resource->getName()
                : $this->resource->name,
            'email' => method_exists($this->resource, 'getEmail')
                ? $this->resource->getEmail()
                : $this->resource->email,
        ];
    }
}
