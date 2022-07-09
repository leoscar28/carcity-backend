<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Instruction\InstructionCollection;
use App\Services\InstructionService;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    protected InstructionService $instructionService;
    public function __construct(InstructionService $instructionService)
    {
        $this->instructionService   =   $instructionService;
    }

    public function get(): InstructionCollection
    {
        return new InstructionCollection($this->instructionService->get());
    }

}
