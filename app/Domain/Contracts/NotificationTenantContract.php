<?php

namespace App\Domain\Contracts;

class NotificationTenantContract extends MainContract
{
    const TABLE =   'notification_tenants';
    const FILLABLE  =   [
        self::USER_ID,
        self::TYPE,
        self::APPLICATION_ID,
        self::COMPLETION_ID,
        self::INVOICE_ID,
        self::VIEW,
        self::STATUS
    ];
}
