<?php

namespace App\Http\Resources\Invoice;

use App\Domain\Contracts\MainContract;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceRidResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::RID   =>  $this->{MainContract::RID},
            MainContract::UPLOAD_STATUS_ID  =>  $this->{MainContract::UPLOAD_STATUS_ID},
            MainContract::CUSTOMER   =>  $this->{MainContract::CUSTOMER},
            MainContract::CUSTOMER_ID   =>  $this->{MainContract::CUSTOMER_ID},
            MainContract::NUMBER    =>  $this->{MainContract::NUMBER},
            MainContract::ORGANIZATION  =>  $this->{MainContract::ORGANIZATION},
            MainContract::DATE  =>  $this->{MainContract::DATE},
            MainContract::SUM   =>  $this->{MainContract::SUM},
            MainContract::NAME  =>  $this->{MainContract::NAME},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  Carbon::createFromFormat('Y-m-d H:i:s', $this->{MainContract::CREATED_AT})->format('d.m.Y'),
            MainContract::INVOICE_STATUS    =>  $this->{MainContract::INVOICE_STATUS},
        ];
    }
}
