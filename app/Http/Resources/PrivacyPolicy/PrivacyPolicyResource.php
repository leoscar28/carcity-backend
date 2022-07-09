<?php

namespace App\Http\Resources\PrivacyPolicy;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivacyPolicyResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::BODY  =>  $this->{MainContract::BODY},
            MainContract::BODY_KZ   =>  $this->{MainContract::BODY_KZ},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
