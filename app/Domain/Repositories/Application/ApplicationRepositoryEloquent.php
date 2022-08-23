<?php

namespace App\Domain\Repositories\Application;

use App\Domain\Contracts\MainContract;
use App\Helpers\Pdf;
use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class ApplicationRepositoryEloquent implements ApplicationRepositoryInterface
{

    #[ArrayShape(['data' => "int"])] public function paginationByCustomerAndNumber($data): array
    {
        if (array_key_exists(MainContract::COMPANY,$data)) {
            $data[MainContract::DATA][] =   [MainContract::CUSTOMER,'like','%'.$data[MainContract::COMPANY].'%'];
        }
        if (array_key_exists(MainContract::NUMBER,$data)) {
            $data[MainContract::DATA][] =   [MainContract::NUMBER,'like',$data[MainContract::NUMBER].'%'];
        }
        $query  =   Application::select(MainContract::RID);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $res    =   $query->groupBy(MainContract::RID)->get();
        $arr    =   [];
        foreach ($res as &$item) {
            $arr[]  =   $item->{MainContract::RID};
        }
        return ['data'  =>  sizeof(array_unique($arr))];
    }

    public function getByCustomerAndNumber($data): Collection|array
    {
        $query  =   Application::with(MainContract::APPLICATION_STATUS);
        $query->where([
            [MainContract::STATUS,1],
        ]);
        if (array_key_exists(MainContract::COMPANY,$data)) {
            $query->where(MainContract::CUSTOMER,'like','%'.$data[MainContract::COMPANY].'%');
        }
        if (array_key_exists(MainContract::NUMBER,$data)) {
            $query->where(MainContract::NUMBER,'like',$data[MainContract::NUMBER].'%');
        }
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

    public function getByRidAndCompany($rid, $company): Collection|array
    {
        return Application::with(MainContract::APPLICATION_STATUS)->where([
            [MainContract::RID,$rid],
            [MainContract::CUSTOMER,'like','%'.$company.'%']
        ])->get();
    }

    public function list($rid)
    {
        return Application::select(
            DB::raw("(min(applications.upload_status_id)) as upload_status_id"),
            DB::raw("(count(applications.id)) as document_all"),
            DB::raw("(DATE_FORMAT(applications.created_at, '%d-%m-%Y')) as created_at"),
            DB::raw("COUNT(NULLIF(users.id,'')) as document_available"),
        )
            ->leftJoin('users', function($join) {
                $join->on('applications.customer_id', '=', 'users.bin');
            })
            ->where([
                ['applications.'.MainContract::RID,$rid],
                ['applications.'.MainContract::STATUS,1],
            ])
            ->orderBy(MainContract::CREATED_AT)
            ->groupBy(DB::raw("DATE_FORMAT(applications.created_at, '%d-%m-%Y')"))
            ->first();
    }

    public function create($data)
    {
        return Application::create($data);
    }

    public function pagination($data)
    {
        $query  =   Application::select(DB::raw("(count(id)) as data"));
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        return $query->first();
    }

    public function all($data): Collection|array
    {
        $query  =   Application::with(MainContract::APPLICATION_STATUS);
        $query->where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
    }

    public function get($data)
    {
        $query  =   Application::where($data[MainContract::DATA]);
        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $query->whereBetween(MainContract::CREATED_AT,$data[MainContract::CREATED_AT]);
        }
        $query->skip(($data[MainContract::PAGINATION]-1) * $data[MainContract::TAKE]);
        $query->take($data[MainContract::TAKE]);
        $query->orderBy(MainContract::ID,'DESC');
        return $query->get();
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

    public function getByRidAndUploadStatusId($rid,$uploadStatusId)
    {
        return Application::where([
            [MainContract::RID,$rid],
            [MainContract::UPLOAD_STATUS_ID,$uploadStatusId],
            [MainContract::STATUS,1]
        ])->limit(300)->get();
    }

    public function getByIds($ids)
    {
        return Application::where(MainContract::STATUS,1)
            ->whereIn(MainContract::ID,$ids)
            ->get();
    }

    public function getByRid($rid)
    {
        return Application::where([
            [MainContract::RID,$rid],
            [MainContract::STATUS,1]
        ])->get();
    }

    public function delete($rid)
    {
        Application::where(MainContract::RID,$rid)->update([
            MainContract::STATUS    =>  0
        ]);
    }

    public function getByCustomerId($customerId)
    {
        return Application::where([
            [MainContract::CUSTOMER_ID,$customerId],
            [MainContract::STATUS,1]
        ])->get();
    }

}
