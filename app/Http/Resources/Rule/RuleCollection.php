<?php

namespace App\Http\Resources\Rule;

use App\Http\Resources\RulesAd\RulesAdResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class RuleCollection extends ResourceCollection
{
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new RuleResource($request);
        });
    }
}
