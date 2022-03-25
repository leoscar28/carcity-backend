<?php

namespace App\Http\Resources\CompletionStatus;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class CompletionStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
