<?php

namespace App\Domain\Contracts;

class InstructionContract extends MainContract
{
    const TABLE =   'instructions';
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
