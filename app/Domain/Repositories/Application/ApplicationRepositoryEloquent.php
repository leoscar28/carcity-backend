<?php

namespace App\Domain\Repositories\Application;

use App\Domain\Contracts\MainContract;
use App\Models\Application;
use Illuminate\Support\Facades\DB;

class ApplicationRepositoryEloquent implements ApplicationRepositoryInterface
{

    public function list($rid)
    {
        return Application::select(
            DB::raw("(min(upload_status_id)) as upload_status_id"),
            DB::raw("(count(id)) as document_all"),
            DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as created_at"),
        )
            ->where([
                [MainContract::RID,$rid],
                [MainContract::STATUS,1]
            ])
            ->orderBy(MainContract::CREATED_AT)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"))
            ->first();
    }

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
            [MainContract::STATUS,1]
        ])->first();
    }

    public function getByRid($rid)
    {
        return Application::where([
            [MainContract::RID,$rid],
            [MainContract::STATUS,1]
        ])->get();
    }

}
