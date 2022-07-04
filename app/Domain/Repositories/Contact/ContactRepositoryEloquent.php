<?php

namespace App\Domain\Repositories\Contact;

use App\Domain\Contracts\MainContract;
use App\Models\Contact;

class ContactRepositoryEloquent implements ContactRepositoryInterface
{
    public function get()
    {
        return Contact::where(MainContract::STATUS,1)->get();
    }
}
