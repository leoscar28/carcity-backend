<?php

namespace App\Http\Resources\UploadStatus;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::TITLE =>  $this->{MainContract::TITLE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
