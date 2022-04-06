<?php

namespace App\Http\Resources\ApplicationSignature;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationSignatureResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::APPLICATION_ID    =>  $this->{MainContract::APPLICATION_ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::SIGNATURE =>  $this->{MainContract::SIGNATURE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
