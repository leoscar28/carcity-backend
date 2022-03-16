<?php

namespace App\Domain\Repositories\Application;

use App\Domain\Contracts\MainContract;
use App\Models\Application;

class ApplicationRepositoryEloquent implements ApplicationRepositoryInterface
{
    public function create($data)
    {
        $application    =   Application::create($data);
        return $this->getById($application->{MainContract::ID});
    }

    public function update($id,$data)
    {
        Application::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id)
    {
        return Application::with(MainContract::APPLICATION_LIST)
            ->where(MainContract::ID,$id)->first();
    }

}
