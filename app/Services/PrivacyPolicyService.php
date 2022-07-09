<?php

namespace App\Services;

use App\Domain\Repositories\PrivacyPolicy\PrivacyPolicyRepositoryInterface;

class PrivacyPolicyService
{
    protected PrivacyPolicyRepositoryInterface $privacyPolicyRepository;
    public function __construct(PrivacyPolicyRepositoryInterface $privacyPolicyRepository)
    {
        $this->privacyPolicyRepository  =   $privacyPolicyRepository;
    }

    public function get()
    {
        return $this->privacyPolicyRepository->get();
    }

}
