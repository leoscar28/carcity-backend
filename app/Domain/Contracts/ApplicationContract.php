<?php

namespace App\Domain\Contracts;

class ApplicationContract extends MainContract
{
    const TABLE =   'applications';
    const FILLABLE  =   [
        self::RID,
        self::UPLOAD_STATUS_ID,
        self::CUSTOMER,
        self::CUSTOMER_ID,
        self::NUMBER,
        self::ORGANIZATION,
        self::DATE,
        self::SUM,
        self::NAME,
        self::STATUS
    ];
}
