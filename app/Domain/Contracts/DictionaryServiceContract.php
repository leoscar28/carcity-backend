<?php

namespace App\Domain\Contracts;

class DictionaryServiceContract extends MainContract
{
    const TABLE =   'dictionary_services';
    const FILLABLE  =   [
        self::NAME,
        self::STATUS,
        self::FOR_MENU
    ];
}
