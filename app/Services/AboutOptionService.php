<?php

namespace App\Services;

use App\Domain\Repositories\AboutOption\AboutOptionRepositoryInterface;

class AboutOptionService
{
    protected AboutOptionRepositoryInterface $aboutOptionRepository;
    public function __construct(AboutOptionRepositoryInterface $aboutOptionRepository)
    {
        $this->aboutOptionRepository    =   $aboutOptionRepository;
    }

    public function get()
    {
        return $this->aboutOptionRepository->get();
    }

}
