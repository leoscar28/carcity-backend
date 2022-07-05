<?php

namespace App\Domain\Repositories\TermsOfUse;

use App\Domain\Contracts\MainContract;
use App\Models\TermsOfUse;

class TermsOfUseRepositoryEloquent implements TermsOfUseRepositoryInterface
{
    public function get()
    {
        return TermsOfUse::where(MainContract::STATUS,1)->get();
    }
}
