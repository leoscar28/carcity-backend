<?php

namespace App\Services;

use App\Domain\Repositories\Contact\ContactRepositoryInterface;

class ContactService
{
    protected ContactRepositoryInterface $contactRepository;
    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository    =   $contactRepository;
    }

    public function get()
    {
        return $this->contactRepository->get();
    }

}
