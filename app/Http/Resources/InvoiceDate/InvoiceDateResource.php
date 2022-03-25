<?php

namespace App\Http\Resources\InvoiceDate;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\Invoice\InvoiceCollection;
use App\Http\Resources\InvoiceStatus\InvoiceStatusResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::UPLOAD_STATUS_ID  =>  $this->{MainContract::UPLOAD_STATUS_ID},
            MainContract::RID   =>  $this->{MainContract::RID},
            MainContract::DOCUMENT_ALL  =>  $this->{MainContract::DOCUMENT_ALL},
            MainContract::DOCUMENT_AVAILABLE    =>  $this->{MainContract::DOCUMENT_AVAILABLE},
            MainContract::COMMENT   =>  $this->{MainContract::COMMENT},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  Carbon::createFromFormat('Y-m-d H:i:s', $this->{MainContract::CREATED_AT})->format('Y.m.d'),
            MainContract::INVOICE   =>  new InvoiceCollection($this->{MainContract::INVOICE}),
            MainContract::INVOICE_STATUS    =>  new InvoiceStatusResource($this->{MainContract::INVOICE_STATUS})
        ];
    }
}
