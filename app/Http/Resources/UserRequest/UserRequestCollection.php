<?php


namespace App\Http\Resources\UserRequest;


class UserRequestCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new UserRequestResource($request);
        });
    }
}
