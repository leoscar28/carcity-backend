<?php

namespace App\Http\Resources\ApplicationDate;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ApplicationDateWithoutRelationCollection extends ResourceCollection
{
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new ApplicationDateWithoutRelationResource($request);
        });
    }
}
