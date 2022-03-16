<?php

namespace App\Domain\Contracts;

class ApplicationContract extends MainContract
{
    const TABLE =   'applications';
    const FILLABLE  =   [
        self::UPLOAD_STATUS_ID,
        self::DOCUMENT_ALL,
        self::DOCUMENT_AVAILABLE,
        self::COMMENT
    ];
}
