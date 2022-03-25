<?php

namespace App\Http\Resources\InvoiceStatus;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceStatusResource extends JsonResource
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
