<?php

namespace App\Http\Resources\Notification;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\ApplicationDate\ApplicationDateResource;
use App\Http\Resources\CompletionDate\CompletionDateResource;
use App\Http\Resources\InvoiceDate\InvoiceDateResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class NotificationResource extends JsonResource
{
    #[ArrayShape([MainContract::ID => "mixed", MainContract::USER_ID => "mixed", MainContract::TYPE => "mixed", MainContract::APPLICATION_ID => "\App\Http\Resources\Application\ApplicationResource", MainContract::COMPLETION_ID => "\App\Http\Resources\Completion\CompletionResource", MainContract::INVOICE_ID => "\App\Http\Resources\Invoice\InvoiceResource", MainContract::VIEW => "mixed", MainContract::STATUS => "mixed", MainContract::CREATED_AT => "mixed"])] public function toArray($request):array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::TYPE  =>  $this->{MainContract::TYPE},
            MainContract::APPLICATION_ID    =>  new ApplicationDateResource($this->whenLoaded(MainContract::APPLICATIONS)),
            MainContract::COMPLETION_ID =>  new CompletionDateResource($this->whenLoaded(MainContract::COMPLETIONS)),
            MainContract::INVOICE_ID    =>  new InvoiceDateResource($this->whenLoaded(MainContract::INVOICES)),
            MainContract::VIEW  =>  $this->{MainContract::VIEW},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  Carbon::createFromTimeStamp(strtotime($this->{MainContract::CREATED_AT}))->diffForHumans(),
        ];
    }
}
