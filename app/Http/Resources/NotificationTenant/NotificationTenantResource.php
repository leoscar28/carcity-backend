<?php

namespace App\Http\Resources\NotificationTenant;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\Application\ApplicationResource;
use App\Http\Resources\Completion\CompletionResource;
use App\Http\Resources\Invoice\InvoiceResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationTenantResource extends JsonResource implements \App\Domain\Repositories\NotificationTenant\NotificationTenantRepositoryInterface
{
    public function toArray($request):array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::TYPE  =>  $this->{MainContract::TYPE},
            MainContract::APPLICATION_ID    =>  new ApplicationResource($this->whenLoaded(MainContract::APPLICATIONS)),
            MainContract::COMPLETION_ID =>  new CompletionResource($this->whenLoaded(MainContract::COMPLETIONS)),
            MainContract::INVOICE_ID    =>  new InvoiceResource($this->whenLoaded(MainContract::INVOICES)),
            MainContract::VIEW  =>  $this->{MainContract::VIEW},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  Carbon::createFromTimeStamp(strtotime($this->{MainContract::CREATED_AT}))->diffForHumans(),
        ];
    }
}
