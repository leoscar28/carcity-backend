<?php


namespace App\Services;


use App\Domain\Repositories\UserBanner\UserBannerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserBannerService
{
    protected UserBannerRepositoryInterface $userBannerRepository;

    public function __construct(UserBannerRepositoryInterface $userBannerRepository)
    {
        $this->userBannerRepository = $userBannerRepository;
    }

    public function create($data)
    {
        return $this->userBannerRepository->create($data);
    }

    public function update($id,$data)
    {
        return $this->userBannerRepository->update($id,$data);
    }

    public function pagination($data)
    {
        return $this->userBannerRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->userBannerRepository->all($data);
    }

    public function rooms($data): array
    {
        return $this->userBannerRepository->rooms($data);
    }

    public function getById($id)
    {
        return $this->userBannerRepository->getById($id);
    }
    
    public function viewById($data)
    {
        return $this->userBannerRepository->getById($data);
    }

    public function archive($id)
    {
        $this->userBannerRepository->archive($id);
    }

    public function showPhone($id)
    {
        $this->userBannerRepository->showPhone($id);
    }

    public function delete($id)
    {
        $this->userBannerRepository->delete($id);
    }

    public function activate($id)
    {
        return $this->userBannerRepository->activate($id);
    }

    public function publish($id)
    {
        return $this->userBannerRepository->publish($id);
    }

    public function unpublish($id)
    {
        $this->userBannerRepository->unpublish($id);
    }

    public function needEdits($id, $data)
    {
        $this->userBannerRepository->needEdits($id, $data);
    }

    public function up($id)
    {
        $this->userBannerRepository->up($id);
    }
}
