<?php


namespace App\Http\Resources\UserReview;


class UserReviewCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new UserReviewResource($request);
        });
    }
}
