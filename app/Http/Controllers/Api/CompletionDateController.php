<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Events\CompletionDateEvent;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompletionDate\CompletionDateListRequest;
use App\Http\Requests\CompletionDate\CompletionDateUpdateRequest;
use App\Http\Resources\CompletionDate\CompletionDateCollection;
use App\Http\Resources\CompletionDate\CompletionDateResource;
use App\Http\Resources\CompletionDate\CompletionDateWithoutRelationCollection;
use App\Http\Resources\CompletionDate\CompletionDateWithoutRelationResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Jobs\DeleteCompletionTenant;
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use App\Services\NotificationService;
use App\Services\NotificationTenantService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CompletionDateController extends Controller
{
    protected CompletionDateService $completionDateService;
    protected CompletionService $completionService;
    protected NotificationService $notificationService;
    public function __construct(CompletionDateService $completionDateService, CompletionService $completionService, NotificationService $notificationService)
    {
        $this->completionDateService    =   $completionDateService;
        $this->completionService    =   $completionService;
        $this->notificationService  =   $notificationService;
    }

    /**
     * @throws ValidationException
     */
    public function pagination(CompletionDateListRequest $completionDateListRequest)
    {
        $data   =   $completionDateListRequest->check();
        if (array_key_exists(MainContract::COMPANY,$data)||array_key_exists(MainContract::NUMBER,$data)) {
            return $this->completionService->paginationByCustomerAndNumber($data);
        }
        return $this->completionDateService->pagination($data);
    }

    /**
     * @throws ValidationException
     */
    public function list(CompletionDateListRequest $completionDateListRequest): CompletionDateCollection
    {
        return new CompletionDateCollection($this->completionDateService->list($completionDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function get(CompletionDateListRequest $completionDateListRequest): CompletionDateWithoutRelationCollection
    {
        $data   =   $completionDateListRequest->check();
        $completionDates    =   [];
        if (array_key_exists(MainContract::COMPANY,$data)||array_key_exists(MainContract::NUMBER,$data)) {
            $arr    =   [];
            $applications   =   $this->completionService->getByCustomerAndNumber($data);
            foreach ($applications as &$application) {
                if (!array_key_exists($application->{MainContract::RID},$arr)) {
                    $arr[$application->{MainContract::RID}] =   [
                        MainContract::PARENT    =>  $this->completionDateService->getByRid($application->{MainContract::RID}),
                        MainContract::CHILD     =>  []
                    ];
                }
                $arr[$application->{MainContract::RID}][MainContract::CHILD][]  =   $application;
            }
            foreach ($arr as &$item) {
                $item[MainContract::PARENT]->{MainContract::RIDS}   =   $item[MainContract::CHILD];
                $completionDates[] =   $item[MainContract::PARENT];
            }
        } else {
            $completionDates   =   $this->completionDateService->get($data);
        }
        return new CompletionDateWithoutRelationCollection($completionDates);
    }

    /**
     * @throws ValidationException
     */
    public function update($id, CompletionDateUpdateRequest $completionDateUpdateRequest): Response|CompletionDateResource|Application|ResponseFactory
    {
        if ($completionDate = $this->completionDateService->update($id,$completionDateUpdateRequest->check())) {
            return new CompletionDateResource($completionDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function getByRid($rid): Response|CompletionDateResource|Application|ResponseFactory
    {
        if ($completionDate = $this->completionDateService->getByRid($rid)) {
            return new CompletionDateResource($completionDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function getById($id): Response|CompletionDateResource|Application|ResponseFactory
    {
        if ($completionDate = $this->completionDateService->getById($id)) {
            return new CompletionDateResource($completionDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function delete($rid)
    {
        if ($completionDate = $this->completionDateService->getByRid($rid)) {
            $completionDate->{MainContract::STATUS} =   0;
            $completionDate->save();
            $notifications  =   $this->notificationService->getByData([
                MainContract::COMPLETION_ID =>  $completionDate->{MainContract::ID}
            ]);
            foreach ($notifications as &$notification) {
                $notification->{MainContract::STATUS}   =   0;
                $notification->save();
                event(new NotificationEvent(New NotificationResource($notification)));
            }
            event(new CompletionDateEvent(new CompletionDateWithoutRelationResource($completionDate)));
        }
        DeleteCompletionTenant::dispatch($rid);
    }

}
