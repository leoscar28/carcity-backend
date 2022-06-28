<?php

namespace App\Http\Resources\AboutOption;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutOptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::TITLE_KZ  =>  $this->{MainContract::TITLE_KZ},
            MainContract::IMG   =>  $this->{MainContract::IMG},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
