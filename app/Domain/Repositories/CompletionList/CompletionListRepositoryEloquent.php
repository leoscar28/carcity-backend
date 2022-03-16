<?php

namespace App\Domain\Repositories\CompletionList;

use App\Models\CompletionList;

class CompletionListRepositoryEloquent implements CompletionListRepositoryInterface
{
    public function create($data)
    {
        return CompletionList::create($data);
    }
}
