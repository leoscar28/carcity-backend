<?php

namespace App\Services;

use App\Domain\Repositories\NotificationTenant\NotificationTenantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NotificationTenantService
{
    protected NotificationTenantRepositoryInterface $notificationTenantRepository;
    public function __construct(NotificationTenantRepositoryInterface $notificationTenantRepository)
    {
        $this->notificationTenantRepository =   $notificationTenantRepository;
    }

    public function create($data): ?object
    {
        return $this->notificationTenantRepository->create($data);
    }

    public function getByUserId($userId,$skip): Collection|array
    {
        return $this->notificationTenantRepository->getByUserId($userId,$skip);
    }

    public function viewCount($userId)
    {
        return $this->notificationTenantRepository->viewCount($userId);
    }

    public function count($userId)
    {
        return $this->notificationTenantRepository->count($userId);
    }

    public function get($data): Collection|array
    {
        return $this->notificationTenantRepository->get($data);
    }

    public function update($id,$data): void
    {
        $this->notificationTenantRepository->update($id,$data);
    }

    public function updateByIds($ids,$data): void
    {
        $this->notificationTenantRepository->updateByIds($ids,$data);
    }
}
