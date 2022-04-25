<?php

namespace App\Services;

use App\Domain\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    protected NotificationRepositoryInterface $notificationRepository;
    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository   =   $notificationRepository;
    }

    public function create($data): ?object
    {
        return $this->notificationRepository->create($data);
    }

    public function getByUserId($userId,$skip): Collection|array
    {
        return $this->notificationRepository->getByUserId($userId,$skip);
    }

    public function viewCount($userId)
    {
        return $this->notificationRepository->viewCount($userId);
    }

    public function count($userId)
    {
        return $this->notificationRepository->count($userId);
    }

    public function get($data): Collection|array
    {
        return $this->notificationRepository->get($data);
    }

    public function update($id,$data): void
    {
        $this->notificationRepository->update($id,$data);
    }

    public function updateByIds($ids,$data): void
    {
        $this->notificationRepository->updateByIds($ids,$data);
    }

    public function getByData($data)
    {
        return $this->notificationRepository->getByData($data);
    }

}
