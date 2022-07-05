<?php

namespace App\Services;

use App\Domain\Repositories\TermsOfUse\TermsOfUseRepositoryInterface;

class TermsOfUseService
{
    protected TermsOfUseRepositoryInterface $termsOfUseRepository;
    public function __construct(TermsOfUseRepositoryInterface $termsOfUseRepository)
    {
        $this->termsOfUseRepository =   $termsOfUseRepository;
    }

    public function get()
    {
        return $this->termsOfUseRepository->get();
    }

}
