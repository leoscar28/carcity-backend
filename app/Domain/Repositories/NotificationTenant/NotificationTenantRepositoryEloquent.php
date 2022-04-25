<?php

namespace App\Domain\Repositories\NotificationTenant;

use App\Domain\Contracts\MainContract;
use App\Models\NotificationTenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class NotificationTenantRepositoryEloquent implements NotificationTenantRepositoryInterface
{

    public function create($data): ?object
    {
        $notification = NotificationTenant::create($data);
        return $this->getById($notification->{MainContract::ID});
    }

    public function getById($id): object|null
    {
        return NotificationTenant::with(MainContract::COMPLETIONS,MainContract::APPLICATIONS,MainContract::INVOICES)
            ->where([
                [MainContract::ID,$id],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function getByUserId($userId,$skip): Collection|array
    {
        return NotificationTenant::with(MainContract::COMPLETIONS,MainContract::APPLICATIONS,MainContract::INVOICES)
            ->where([
                [MainContract::USER_ID,$userId],
                [MainContract::STATUS,1]
            ])
            ->orderBy(MainContract::ID,'desc')
            ->skip($skip)
            ->take(10)
            ->get();
    }

    public function viewCount($userId)
    {
        return NotificationTenant::select(DB::raw("(count(id)) as data"))->where([
            [MainContract::USER_ID,$userId],
            [MainContract::VIEW,0],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function count($userId)
    {
        return NotificationTenant::select(DB::raw("(count(id)) as data"))->where([
            [MainContract::USER_ID,$userId],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function get($data): Collection|array
    {
        return NotificationTenant::with(MainContract::COMPLETIONS,MainContract::APPLICATIONS,MainContract::INVOICES)
            ->where([
                [MainContract::USER_ID,$data[MainContract::USER_ID]],
                [MainContract::STATUS,1]
            ])
            ->orderBy(MainContract::ID,'desc')
            ->skip($data[MainContract::SKIP])
            ->take(10)
            ->get();
    }

    public function update($id,$data)
    {
        NotificationTenant::where(MainContract::ID,$id)->update($data);
    }

    public function updateByIds($ids,$data)
    {
        NotificationTenant::whereIn(MainContract::ID,$ids)->update($data);
    }

    public function getByData($data)
    {
        return NotificationTenant::where($data)->get();
    }

}
