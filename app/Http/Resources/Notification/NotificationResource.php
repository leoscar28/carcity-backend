<?php

namespace App\Http\Resources\Notification;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::FOREIGN_ID    =>  $this->{MainContract::FOREIGN_ID},
            MainContract::TYPE  =>  $this->{MainContract::TYPE},
            MainContract::VIEW  =>  $this->{MainContract::VIEW},
            MainContract::STATUS    =>  $this->{MainContract::STATUS},
            MainContract::CREATED_AT    =>  $this->{MainContract::CREATED_AT}
        ];
    }
}
