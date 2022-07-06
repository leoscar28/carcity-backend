<?php

namespace App\Domain\Repositories\DictionaryBrand;

use App\Domain\Contracts\MainContract;
use App\Models\DictionaryBrand;

class DictionaryBrandRepositoryEloquent implements DictionaryBrandRepositoryInterface
{
    public function list()
    {
        return DictionaryBrand::where(MainContract::STATUS,1)->get();
    }
}
