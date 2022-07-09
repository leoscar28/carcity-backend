<?php

namespace App\Domain\Contracts;

class PrivacyPolicyContract extends MainContract
{
    const TABLE =   'privacy_policies';
    const FILLABLE  =   [
        self::BODY,
        self::BODY_KZ,
        self::STATUS
    ];
}
