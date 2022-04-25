<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Events\ApplicationDateEvent;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationDate\ApplicationDateListRequest;
use App\Http\Requests\ApplicationDate\ApplicationDateUpdateRequest;
use App\Http\Resources\ApplicationDate\ApplicationDateCollection;
use App\Http\Resources\ApplicationDate\ApplicationDateResource;
use App\Http\Resources\ApplicationDate\ApplicationDateWithoutRelationCollection;
use App\Http\Resources\Notification\NotificationResource;
use App\Jobs\DeleteApplicationTenant;
use App\Models\ApplicationDate;
use App\Models\Notification;
use App\Services\ApplicationDateService;
use App\Services\ApplicationService;
use App\Services\NotificationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ApplicationDateController extends Controller
{
    protected ApplicationDateService $applicationDateService;
    protected ApplicationService $applicationService;
    protected NotificationService $notificationService;
    public function __construct(ApplicationDateService $applicationDateService, ApplicationService $applicationService, NotificationService $notificationService)
    {
        $this->applicationDateService   =   $applicationDateService;
        $this->applicationService   =   $applicationService;
        $this->notificationService  =   $notificationService;
    }

    /**
     * @throws ValidationException
     */
    public function pagination(ApplicationDateListRequest $applicationDateListRequest)
    {
        return $this->applicationDateService->pagination($applicationDateListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function list(ApplicationDateListRequest $applicationDateListRequest): ApplicationDateCollection
    {
        return new ApplicationDateCollection($this->applicationDateService->list($applicationDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function get(ApplicationDateListRequest $applicationDateListRequest): ApplicationDateWithoutRelationCollection
    {
        return new ApplicationDateWithoutRelationCollection($this->applicationDateService->get($applicationDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, ApplicationDateUpdateRequest $applicationDateUpdateRequest): ApplicationDateResource|Response|Application|ResponseFactory
    {
        if ($applicationDate = $this->applicationDateService->update($id,$applicationDateUpdateRequest->check())) {
            return new ApplicationDateResource($applicationDate);
        }
        return response(['message'  =>  'ApplicationDate not found'],404);
    }

    public function getByRid($rid): ApplicationDateResource|Response|Application|ResponseFactory
    {
        if ($applicationDate = $this->applicationDateService->getByRid($rid)) {
            return new ApplicationDateResource($applicationDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function getById($id): ApplicationDateResource|Response|Application|ResponseFactory
    {
        if ($applicationDate = $this->applicationDateService->getById($id)) {
            return new ApplicationDateResource($applicationDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function delete($rid)
    {
        if ($applicationDate = $this->applicationDateService->getByRid($rid)) {
            $applicationDate->{MainContract::STATUS}    =   0;
            $applicationDate->save();
            $notifications  =   $this->notificationService->getByData([
                MainContract::APPLICATION_ID    =>  $applicationDate->{MainContract::ID}
            ]);
            foreach ($notifications as &$notification) {
                $notification->{MainContract::STATUS}   =   0;
                $notification->save();
                event(new NotificationEvent(New NotificationResource($notification)));
            }
            event(new ApplicationDateEvent(new ApplicationDateResource($applicationDate)));
        }
        DeleteApplicationTenant::dispatch($rid);
    }

}
