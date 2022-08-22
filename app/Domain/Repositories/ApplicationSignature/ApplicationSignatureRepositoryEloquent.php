<?php

namespace App\Domain\Repositories\ApplicationSignature;

use App\Domain\Contracts\MainContract;
use App\Models\ApplicationSignature;

class ApplicationSignatureRepositoryEloquent implements ApplicationSignatureRepositoryInterface
{

    public function create($data)
    {
        return ApplicationSignature::create($data);
    }

    public function getByApplicationIdAndUserId($applicationId,$userId)
    {
        return ApplicationSignature::where([
            [MainContract::APPLICATION_ID,$applicationId],
            [MainContract::USER_ID,$userId],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function existsByApplicationIdAndUserId($applicationId,$userId)
    {
        return ApplicationSignature::where([
            [MainContract::APPLICATION_ID,$applicationId],
            [MainContract::USER_ID,$userId],
            [MainContract::STATUS,1]
        ])->exists();
    }

    public function update($id,$data)
    {
        ApplicationSignature::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return ApplicationSignature::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function getByApplicationId($id)
    {
        return ApplicationSignature::where([
            [MainContract::APPLICATION_ID,$id],
            [MainContract::STATUS,1]
        ])->get();
    }
}
