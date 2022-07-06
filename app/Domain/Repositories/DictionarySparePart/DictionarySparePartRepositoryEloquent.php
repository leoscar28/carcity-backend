<?php

namespace App\Domain\Repositories\DictionarySparePart;

use App\Domain\Contracts\MainContract;
use App\Models\DictionarySparePart;

class DictionarySparePartRepositoryEloquent implements DictionarySparePartRepositoryInterface
{
    public function list()
    {
        return DictionarySparePart::where(MainContract::STATUS,1)->get();
    }
}
