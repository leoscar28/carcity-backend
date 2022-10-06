<?php

namespace App\Http\Resources\Announcement;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::DESCRIPTION =>  $this->{MainContract::DESCRIPTION},
            MainContract::CREATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::CREATED_AT})),
            MainContract::UPDATED_AT =>  date('d M Y H:m',strtotime($this->{MainContract::UPDATED_AT}))
        ];
    }
}
