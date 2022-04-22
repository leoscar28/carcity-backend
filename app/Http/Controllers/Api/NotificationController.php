<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationViewRequest;
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

    /**
     * @throws ValidationException
     */
    public function view(NotificationViewRequest $notificationViewRequest): NotificationCollection
    {
        return new NotificationCollection($this->notificationService->view($notificationViewRequest->check()));
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

}
