<?php

namespace App\Services;

use App\Domain\Repositories\Rule\RuleRepositoryInterface;

class RuleService
{
    protected RuleRepositoryInterface $ruleRepository;
    public function __construct(RuleRepositoryInterface $ruleRepository)
    {
        $this->ruleRepository   =   $ruleRepository;
    }

    public function get()
    {
        return $this->ruleRepository->get();
    }

}
