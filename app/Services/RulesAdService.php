<?php

namespace App\Services;

use App\Domain\Repositories\RulesAd\RulesAdRepositoryInterface;

class RulesAdService
{
    protected RulesAdRepositoryInterface $rulesAdRepository;
    public function __construct(RulesAdRepositoryInterface $rulesAdRepository)
    {
        $this->rulesAdRepository    =   $rulesAdRepository;
    }

    public function get()
    {
        return $this->rulesAdRepository->get();
    }

}
