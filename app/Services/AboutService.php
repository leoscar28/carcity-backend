<?php

namespace App\Services;

use App\Domain\Repositories\About\AboutRepositoryInterface;

class AboutService
{
    protected AboutRepositoryInterface $aboutRepository;
    public function __construct(AboutRepositoryInterface $aboutRepository)
    {
        $this->aboutRepository  =   $aboutRepository;
    }

    public function get()
    {
        return $this->aboutRepository->get();
    }

}
