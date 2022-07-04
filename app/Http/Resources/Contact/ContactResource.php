<?php

namespace App\Http\Resources\Contact;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::PHONE =>  $this->{MainContract::PHONE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
