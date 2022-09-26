<?php

namespace App\Http\Resources\FeedbackRequestMessage;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackRequestMessageResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID =>  $this->{MainContract::USER_ID},
            MainContract::USER =>  $this->{MainContract::USER},
            MainContract::TYPE => $this->{MainContract::TYPE},
            MainContract::DESCRIPTION =>  $this->{MainContract::DESCRIPTION},
            MainContract::CREATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::CREATED_AT})),
            MainContract::UPDATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::UPDATED_AT}))
        ];
    }
}
