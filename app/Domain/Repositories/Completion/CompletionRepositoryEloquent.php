<?php

namespace App\Domain\Repositories\Completion;

use App\Domain\Contracts\MainContract;
use App\Models\Completion;

class CompletionRepositoryEloquent implements CompletionRepositoryInterface
{

    public function create($data)
    {
        $completion =   Completion::create($data);
        return $this->getById($completion->{MainContract::ID});
    }

    public function update($id,$data)
    {
        Completion::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Completion::with(MainContract::COMPLETION_LIST)
            ->where(MainContract::ID,$id)->first();
    }

}
