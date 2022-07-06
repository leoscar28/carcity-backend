<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DictionaryService\DictionaryServiceCollection;
use App\Services\DictionaryServiceService;
use Illuminate\Http\Request;

class DictionaryServiceController extends Controller
{
    protected DictionaryServiceService $dictionaryServiceService;
    public function __construct(DictionaryServiceService $dictionaryServiceService)
    {
        $this->dictionaryServiceService  =   $dictionaryServiceService;
    }

    public function list(): DictionaryServiceCollection
    {
        return new DictionaryServiceCollection($this->dictionaryServiceService->list());
    }
}
