<?php

namespace App\Domain\Repositories\CompletionSignature;

use App\Domain\Contracts\MainContract;
use App\Models\CompletionSignature;

class CompletionSignatureRepositoryEloquent implements CompletionSignatureRepositoryInterface
{

    public function create($data)
    {
        return CompletionSignature::create($data);
    }

    public function update($id,$data)
    {
        CompletionSignature::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }


    public function getById($id)
    {
        return CompletionSignature::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function getByCompletionIdAndUserId($completionId,$userId)
    {
        return CompletionSignature::where([
            [MainContract::COMPLETION_ID,$completionId],
            [MainContract::USER_ID,$userId],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function getByCompletionId($id)
    {
        return CompletionSignature::where([
            [MainContract::COMPLETION_ID,$id],
            [MainContract::STATUS,1]
        ])->get();
    }
}
