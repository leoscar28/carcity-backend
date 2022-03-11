<?php

namespace App\Domain\Repositories\Completion;

use App\Domain\Contracts\MainContract;
use App\Models\Completion;

class CompletionRepositoryEloquent implements CompletionRepositoryInterface
{

    public function create($data)
    {
        return Completion::create($data);
    }

    public function update($id,$data)
    {
        Completion::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Completion::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,MainContract::TRUE]
        ])->first();
    }

}
