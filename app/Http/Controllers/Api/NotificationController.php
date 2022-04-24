<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationViewRequest;
use App\Http\Requests\Notification\NotificationViewUpdateRequest;
use App\Http\Resources\Notification\NotificationCollection;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService  =   $notificationService;
    }

    public function getByUserId($userId,$skip): NotificationCollection
    {
        return new NotificationCollection($this->notificationService->getByUserId($userId,$skip));
    }

    public function viewCount($userId)
    {
        return $this->notificationService->viewCount($userId);
    }

    public function count($userId)
    {
        return $this->notificationService->count($userId);
    }

    /**
     * @throws ValidationException
     */
    public function get(NotificationViewRequest $notificationViewRequest): NotificationCollection
    {
        return new NotificationCollection($this->notificationService->get($notificationViewRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function setView(NotificationViewUpdateRequest $notificationViewUpdateRequest)
    {
        $data   =   $notificationViewUpdateRequest->check();
        $this->notificationService->updateByIds($data[MainContract::IDS],[
            MainContract::VIEW  =>  1
        ]);
        return $this->notificationService->viewCount($data[MainContract::USER_ID]);
    }

}
