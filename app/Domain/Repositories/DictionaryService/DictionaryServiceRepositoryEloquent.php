<?php

namespace App\Domain\Repositories\DictionaryService;

use App\Domain\Contracts\MainContract;
use App\Models\DictionaryService;

class DictionaryServiceRepositoryEloquent implements DictionaryServiceRepositoryInterface
{
    public function list()
    {
        return DictionaryService::where(MainContract::STATUS,1)->get();
    }
}
