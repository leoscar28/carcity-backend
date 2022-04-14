<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationCreateRequest;
use App\Http\Requests\Application\ApplicationDownloadRequest;
use App\Http\Requests\Application\ApplicationListRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Http\Resources\Application\ApplicationCollection;
use App\Http\Resources\Application\ApplicationResource;
use App\Jobs\ApplicationCount;
use App\Services\ApplicationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    protected ApplicationService $applicationService;
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService   =   $applicationService;
    }


    public function downloadAll($rid): Response|Application|ResponseFactory
    {
        $applications   =   $this->applicationService->getByRid($rid);
        if (sizeof($applications) > 0) {
            $arr    =   [];
            foreach ($applications as &$application) {
                if (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx')) {
                    $arr[]  =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx';
                } elseif (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx')) {
                    $arr[]  =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx';
                } elseif (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.zip')) {
                    $arr[]  =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.zip';
                }
            }
            if (sizeof($arr) > 0) {
                return response([MainContract::DATA =>  $arr],200);
            }
            return response(['message'  =>  'Документы не найдены'],404);
        }
        return response(['message'  =>  'Запись не найдена'],404);
    }

    /**
     * @throws ValidationException
     */
    public function download(ApplicationDownloadRequest $applicationDownloadRequest): Response|Application|ResponseFactory
    {
        $data   =   $applicationDownloadRequest->check();
        if ($application = $this->applicationService->getById($data[MainContract::ID])) {
            if (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx')) {
                $data[MainContract::LINK]   =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx';
                return response([MainContract::DATA =>  $data],200);
            } elseif (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx')) {
                $data[MainContract::LINK]   =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx';
                return response([MainContract::DATA =>  $data],200);
            } elseif (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.zip')) {
                $data[MainContract::LINK]   =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.zip';
                return response([MainContract::DATA =>  $data],200);
            }
            return response(['message'  =>  'Файл не найден или еще не загружен на сервер'],404);
        }
        return response(['message'  =>  'Запись не найдена'],404);
    }

    /**
     * @throws ValidationException
     */
    public function create(ApplicationCreateRequest $applicationCreateRequest): ApplicationCollection
    {
        $data   =   $applicationCreateRequest->check();
        $arr    =   [];
        foreach ($data[MainContract::DATA] as &$applicationItem) {
            $arr[]  =   $this->applicationService->create($applicationItem);
        }
        ApplicationCount::dispatch($data[MainContract::RID]);
        return new ApplicationCollection($arr);
    }

    /**
     * @throws ValidationException
     */
    public function pagination(ApplicationListRequest $completionListRequest)
    {
        return $this->applicationService->pagination($completionListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function all(ApplicationListRequest $completionListRequest): ApplicationCollection
    {
        return new ApplicationCollection($this->applicationService->all($completionListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function get(ApplicationListRequest $completionListRequest): ApplicationCollection
    {
        return new ApplicationCollection($this->applicationService->get($completionListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, ApplicationUpdateRequest $applicationUpdateRequest): Response|ApplicationResource|Application|ResponseFactory
    {
        $application = $this->applicationService->update($id,$applicationUpdateRequest->check());
        if ($application) {
            ApplicationCount::dispatch($application->{MainContract::RID});
            return new ApplicationResource($application);
        }
        return response(['message'  =>  'Application not found'],404);
    }

    public function getById($id): Response|ApplicationResource|Application|ResponseFactory
    {
        if ($application = $this->applicationService->getById($id)) {
            return new ApplicationResource($application);
        }
        return response(['message'  =>  'Application not found'],404);
    }

    public function getByRid($rid): ApplicationCollection
    {
        return new ApplicationCollection($this->applicationService->getByRid($rid));
    }

    public function delete($rid,$id)
    {
        $this->applicationService->update($id,[
            MainContract::STATUS    =>  0
        ]);
        ApplicationCount::dispatch($rid);
    }

}
