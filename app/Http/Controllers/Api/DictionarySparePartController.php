<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DictionarySparePart\DictionarySparePartCollection;
use App\Services\DictionarySparePartService;
use Illuminate\Http\Request;

class DictionarySparePartController extends Controller
{
    protected DictionarySparePartService $dictionarySparePartService;
    public function __construct(DictionarySparePartService $dictionarySparePartService)
    {
        $this->dictionarySparePartService  =   $dictionarySparePartService;
    }

    public function list(): DictionarySparePartCollection
    {
        return new DictionarySparePartCollection($this->dictionarySparePartService->list());
    }
}
