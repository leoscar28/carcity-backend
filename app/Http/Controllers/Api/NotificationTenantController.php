<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationTenant\NotificationTenantViewRequest;
use App\Http\Requests\NotificationTenant\NotificationTenantViewUpdateRequest;
use App\Http\Resources\NotificationTenant\NotificationTenantCollection;
use App\Services\NotificationTenantService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotificationTenantController extends Controller
{
    protected NotificationTenantService $notificationTenantService;
    public function __construct(NotificationTenantService $notificationTenantService)
    {
        $this->notificationTenantService    =   $notificationTenantService;
    }

    public function getByUserId($userId,$skip): NotificationTenantCollection
    {
        return new NotificationTenantCollection($this->notificationTenantService->getByUserId($userId,$skip));
    }

    public function viewCount($userId)
    {
        return $this->notificationTenantService->viewCount($userId);
    }

    public function count($userId)
    {
        return $this->notificationTenantService->count($userId);
    }

    /**
     * @throws ValidationException
     */
    public function get(NotificationTenantViewRequest $notificationViewRequest): NotificationTenantCollection
    {
        return new NotificationTenantCollection($this->notificationTenantService->get($notificationViewRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function setView(NotificationTenantViewUpdateRequest $notificationViewUpdateRequest)
    {
        $data   =   $notificationViewUpdateRequest->check();
        $this->notificationTenantService->updateByIds($data[MainContract::IDS],[
            MainContract::VIEW  =>  1
        ]);
        return $this->notificationTenantService->viewCount($data[MainContract::USER_ID]);
    }

}
