<?php

namespace App\Http\Resources\CompletionDate;

use App\Domain\Contracts\MainContract;
use App\Http\Resources\Completion\CompletionCollection;
use App\Http\Resources\CompletionStatus\CompletionStatusResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CompletionDateResource extends JsonResource
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
            MainContract::CREATED_AT    =>  Carbon::createFromFormat('Y-m-d H:i:s', $this->{MainContract::CREATED_AT})->format('d.m.Y'),
            MainContract::RIDS  =>  new CompletionCollection($this->{MainContract::COMPLETION}),
            MainContract::COMPLETION_STATUS =>  new CompletionStatusResource($this->{MainContract::COMPLETION_STATUS}),
            MainContract::RID_STATUS    =>  false
        ];
    }
}
