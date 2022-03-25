<?php

namespace App\Domain\Contracts;

class InvoiceStatusContract extends MainContract
{
    const TABLE =   'invoice_statuses';
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
