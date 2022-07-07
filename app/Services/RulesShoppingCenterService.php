<?php

namespace App\Services;

use App\Domain\Repositories\RulesShoppingCenter\RulesShoppingCenterRepositoryInterface;

class RulesShoppingCenterService
{
    protected RulesShoppingCenterRepositoryInterface $rulesShoppingCenterRepository;
    public function __construct(RulesShoppingCenterRepositoryInterface $rulesShoppingCenterRepository)
    {
        $this->rulesShoppingCenterRepository    =   $rulesShoppingCenterRepository;
    }

    public function get()
    {
        return $this->rulesShoppingCenterRepository->get();
    }

}
