<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ContactCollection;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected ContactService $contactService;
    public function __construct(ContactService $contactService)
    {
        $this->contactService   =   $contactService;
    }

    public function get(): ContactCollection
    {
        return new ContactCollection($this->contactService->get());
    }

}
