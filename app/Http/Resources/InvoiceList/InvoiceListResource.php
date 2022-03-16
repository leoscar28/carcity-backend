<?php

namespace App\Http\Resources\InvoiceList;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::INVOICE_ID    =>  $this->{MainContract::INVOICE_ID},
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
