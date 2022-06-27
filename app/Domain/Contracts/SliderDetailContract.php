<?php

namespace App\Domain\Contracts;

class SliderDetailContract extends MainContract
{
    const TABLE =   'slider_details';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::STATUS
    ];
}
