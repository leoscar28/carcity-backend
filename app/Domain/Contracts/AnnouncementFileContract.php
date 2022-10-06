<?php

namespace App\Domain\Contracts;

class AnnouncementFileContract extends MainContract
{
    const TABLE =   'announcement_files';

    const FILLABLE = [
        MainContract::ANNOUNCEMENT_ID,
        MainContract::TITLE,
        MainContract::PATH
    ];
}
