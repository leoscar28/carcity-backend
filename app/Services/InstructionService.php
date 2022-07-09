<?php

namespace App\Services;

use App\Domain\Repositories\Instruction\InstructionRepositoryInterface;

class InstructionService
{
    protected InstructionRepositoryInterface $instructionRepository;
    public function __construct(InstructionRepositoryInterface $instructionRepository)
    {
        $this->instructionRepository    =   $instructionRepository;
    }

    public function get()
    {
        return $this->instructionRepository->get();
    }
}
