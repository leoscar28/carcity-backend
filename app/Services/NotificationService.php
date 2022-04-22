<?php

namespace App\Services;

use App\Domain\Repositories\Notification\NotificationRepositoryInterface;

class NotificationService
{
    protected NotificationRepositoryInterface $notificationRepository;
    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository   =   $notificationRepository;
    }

    public function getByUserId($userId,$skip)
    {
        return $this->notificationRepository->getByUserId($userId,$skip);
    }

    public function viewCount($userId)
    {
        return $this->notificationRepository->viewCount($userId);
    }

    public function view($data)
    {
        return $this->notificationRepository->view($data);
    }

    public function count($userId)
    {
        return $this->notificationRepository->count($userId);
    }

    public function get($data)
    {
        return $this->notificationRepository->get($data);
    }

}
