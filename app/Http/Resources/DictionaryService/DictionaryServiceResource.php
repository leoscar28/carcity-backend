<?php

namespace App\Http\Resources\DictionaryService;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class DictionaryServiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::NAME =>  $this->{MainContract::NAME},
            MainContract::NAME_KZ =>  $this->{MainContract::NAME_KZ},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::FOR_MENU    =>  $this->{MainContract::FOR_MENU}
        ];
    }
}
