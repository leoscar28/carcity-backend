<?php

namespace App\Http\Resources\Application;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\ApplicationList\ApplicationListCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::UPLOAD_STATUS_ID  =>  $this->{MainContract::UPLOAD_STATUS_ID},
            MainContract::CUSTOMER_ID   =>  $this->{MainContract::CUSTOMER_ID},
            MainContract::DOCUMENT_ALL    =>  $this->{MainContract::DOCUMENT_AVAILABLE},
            MainContract::COMMENT  =>  $this->{MainContract::COMMENT},
            MainContract::APPLICATION_LIST  =>  new ApplicationListCollection($this->{MainContract::APPLICATION_LIST})
        ];
    }
}
