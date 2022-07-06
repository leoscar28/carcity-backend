<?php


namespace App\Domain\Contracts;


class AntimatWordContract extends MainContract
{
    const TABLE =   'antimat_words';

    const FILLABLE  =   [
        self::WORD,
        self::REPLACEMENT
    ];
}
