<?php

namespace App\Http\Resources\AnnouncementRecipient;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementRecipientResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::USER_ID =>  $this->{MainContract::USER_ID},
            MainContract::USER =>  $this->{MainContract::USER},
            MainContract::FILE =>  $this->{MainContract::FILE},
            MainContract::ANNOUNCEMENT =>  $this->{MainContract::ANNOUNCEMENT},
            MainContract::VIEW =>  $this->{MainContract::VIEW},
            MainContract::CREATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::CREATED_AT})),
            MainContract::UPDATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::UPDATED_AT}))
        ];
    }
}
