<?php

namespace App\Domain\Contracts;

class InvoiceContract extends MainContract
{
    const TABLE =   'invoices';
    const FILLABLE  =   [
        self::UPLOAD_STATUS_ID,
        self::DOCUMENT_ALL,
        self::DOCUMENT_AVAILABLE,
        self::COMMENT
    ];
}
