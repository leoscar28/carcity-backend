<?php

namespace App\Http\Resources\Invoice;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\InvoiceList\InvoiceListCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::UPLOAD_STATUS_ID  =>  $this->{MainContract::UPLOAD_STATUS_ID},
            MainContract::CUSTOMER_ID   =>  $this->{MainContract::CUSTOMER_ID},
            MainContract::DOCUMENT_ALL    =>  $this->{MainContract::DOCUMENT_AVAILABLE},
            MainContract::COMMENT  =>  $this->{MainContract::COMMENT},
            MainContract::INVOICE_LIST  =>  new InvoiceListCollection($this->{MainContract::INVOICE_LIST})
        ];
    }
}
