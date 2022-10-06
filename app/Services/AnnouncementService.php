<?php


namespace App\Services;


use App\Domain\Repositories\Announcement\AnnouncementRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AnnouncementService
{
    protected AnnouncementRepositoryInterface $announcementRepository;

    public function __construct(AnnouncementRepositoryInterface $announcementRepository)
    {
        $this->announcementRepository = $announcementRepository;
    }

    public function create($data)
    {
        return $this->announcementRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->announcementRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->announcementRepository->all($data);
    }


    public function getById($id)
    {
        return $this->announcementRepository->getById($id);
    }

}
