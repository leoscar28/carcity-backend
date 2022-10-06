<?php

namespace App\Http\Resources\FeedbackRequest;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\FeedbackRequestMessage\FeedbackRequestMessageCollection;
use App\Http\Resources\FeedbackRequestMessage\FeedbackRequestMessageResource;
use App\Http\Resources\FeedbackRequestTheme\FeedbackRequestThemeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackRequestResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID =>  $this->{MainContract::USER_ID},
            MainContract::USER =>  $this->{MainContract::USER},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::FIRST_MESSAGE =>  new FeedbackRequestMessageResource($this->firstMessage),
            MainContract::MESSAGES =>  new FeedbackRequestMessageCollection($this->messages),
            MainContract::STATUS =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::CREATED_AT})),
            MainContract::UPDATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::UPDATED_AT}))
        ];
    }
}
