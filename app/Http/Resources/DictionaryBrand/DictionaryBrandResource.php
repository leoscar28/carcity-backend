<?php

namespace App\Http\Resources\DictionaryBrand;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class DictionaryBrandResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::NAME =>  $this->{MainContract::NAME},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::FOR_MENU    =>  $this->{MainContract::FOR_MENU}
        ];
    }
}
