<?php

namespace App\Domain\Repositories\Application;

use App\Domain\Contracts\MainContract;
use App\Models\Application;

class ApplicationRepositoryEloquent implements ApplicationRepositoryInterface
{
    public function create($data)
    {
        return Application::create($data);
    }

    public function update($id,$data)
    {
        Application::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Application::where([
            [MainContract::ID,$id],
            [MainContract::STATUS,MainContract::TRUE]
        ])->first();
    }

}
