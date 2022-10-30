<?php

namespace App\Domain\Contracts;

class DictionaryServiceContract extends MainContract
{
    const TABLE =   'dictionary_services';
    const FILLABLE  =   [
        self::NAME,
        self::NAME_KZ,
        self::STATUS,
        self::FOR_MENU
    ];
}
