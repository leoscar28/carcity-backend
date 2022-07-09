<?php

namespace App\Domain\Repositories\PrivacyPolicy;

use App\Domain\Contracts\MainContract;
use App\Models\PrivacyPolicy;

class PrivacyPolicyRepositoryEloquent implements PrivacyPolicyRepositoryInterface
{
    public function get()
    {
        return PrivacyPolicy::where(MainContract::STATUS,1)->get();
    }
}
