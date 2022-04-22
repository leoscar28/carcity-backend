<?php

namespace App\Domain\Repositories\Notification;

use App\Domain\Contracts\MainContract;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepositoryEloquent implements NotificationRepositoryInterface
{
    public function getByUserId($userId,$skip)
    {
        return Notification::where([
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
        return Notification::select(DB::raw("(count(id)) as data"))->where([
            [MainContract::USER_ID,$userId],
            [MainContract::VIEW,0],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function view($data)
    {
        return Notification::where([
            [MainContract::USER_ID,$data[MainContract::USER_ID]],
            [MainContract::VIEW,0],
            [MainContract::STATUS,1]
        ])
            ->skip($data[MainContract::SKIP])
            ->take(10)
            ->get();
    }

    public function count($userId)
    {
        return Notification::select(DB::raw("(count(id)) as data"))->where([
            [MainContract::USER_ID,$userId],
            [MainContract::STATUS,1]
        ])->first();
    }

    public function get($data)
    {
        return Notification::where([
            [MainContract::USER_ID,$data[MainContract::USER_ID]],
            [MainContract::STATUS,1]
        ])
            ->skip($data[MainContract::SKIP])
            ->take(10)
            ->get();
    }
}
