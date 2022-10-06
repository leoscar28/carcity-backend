<?php


namespace App\Services;


use App\Domain\Repositories\AnnouncementRecipient\AnnouncementRecipientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AnnouncementRecipientService
{
    protected AnnouncementRecipientRepositoryInterface $announcementRecipientRepository;

    public function __construct(AnnouncementRecipientRepositoryInterface $announcementRecipientRepository)
    {
        $this->announcementRecipientRepository = $announcementRecipientRepository;
    }

    public function create($data)
    {
        return $this->announcementRecipientRepository->create($data);
    }

    public function pagination($data)
    {
        return $this->announcementRecipientRepository->pagination($data);
    }

    public function all($data): Collection|array
    {
        return $this->announcementRecipientRepository->all($data);
    }


    public function getById($id)
    {
        return $this->announcementRecipientRepository->getById($id);
    }

    public function setView($id)
    {
        return $this->announcementRecipientRepository->setView($id);
    }

    public function getNotViewed($data)
    {
        return $this->announcementRecipientRepository->getNotViewed($data);
    }

}
