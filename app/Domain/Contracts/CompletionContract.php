<?php

namespace App\Domain\Contracts;

class CompletionContract extends MainContract
{
    const TABLE =   'completions';
    const FILLABLE  =   [
        self::UPLOAD_STATUS_ID,
        self::DOCUMENT_ALL,
        self::DOCUMENT_AVAILABLE,
        self::COMMENT
    ];
}
