<?php


namespace App\Http\Resources\FeedbackRequestMessage;


class FeedbackRequestMessageCollection extends \Illuminate\Http\Resources\Json\ResourceCollection
{
    public function toArray($request): array|Collection|\JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($request) {
            return new FeedbackRequestMessageResource($request);
        });
    }
}
