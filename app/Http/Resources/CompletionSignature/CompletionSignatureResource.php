<?php

namespace App\Http\Resources\CompletionSignature;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class CompletionSignatureResource extends JsonResource
{
    #[ArrayShape([MainContract::ID => "mixed", MainContract::COMPLETION_ID => "mixed", MainContract::USER_ID => "mixed", MainContract::SIGNATURE => "mixed", MainContract::STATUS => "mixed"])] public function toArray($request):array
    {
        return [
            MainContract::ID    =>  $this->{MainContract::ID},
            MainContract::COMPLETION_ID    =>  $this->{MainContract::COMPLETION_ID},
            MainContract::USER_ID   =>  $this->{MainContract::USER_ID},
            MainContract::SIGNATURE =>  $this->{MainContract::SIGNATURE},
            MainContract::STATUS    =>  $this->{MainContract::STATUS}
        ];
    }
}
