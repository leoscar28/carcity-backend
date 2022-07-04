<?php

namespace App\Http\Resources\Infrastructure;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class InfrastructureResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::TITLE_KZ  =>  $this->{MainContract::TITLE_KZ},
            MainContract::DESCRIPTION   =>  $this->{MainContract::DESCRIPTION},
            MainContract::DESCRIPTION_KZ    =>  $this->{MainContract::DESCRIPTION_KZ},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
