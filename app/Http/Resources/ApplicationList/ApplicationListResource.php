<?php

namespace App\Http\Resources\ApplicationList;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationListResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::APPLICATION_ID    =>  $this->{MainContract::APPLICATION_ID},
            MainContract::CUSTOMER  =>  $this->{MainContract::CUSTOMER},
            MainContract::CUSTOMER_ID   =>  $this->{MainContract::CUSTOMER_ID},
            MainContract::NUMBER    =>  $this->{MainContract::NUMBER},
            MainContract::ORGANIZATION  =>  $this->{MainContract::ORGANIZATION},
            MainContract::DATE  =>  $this->{MainContract::DATE},
            MainContract::SUM   =>  $this->{MainContract::SUM},
            MainContract::NAME  =>  $this->{MainContract::NAME},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
        ];
    }
}
