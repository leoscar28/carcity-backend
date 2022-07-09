<?php

namespace App\Domain\Repositories\Instruction;

use App\Domain\Contracts\MainContract;
use App\Models\Instruction;

class InstructionRepositoryEloquent implements InstructionRepositoryInterface
{
    public function get()
    {
        return Instruction::where(MainContract::STATUS,1)->get();
    }
}
