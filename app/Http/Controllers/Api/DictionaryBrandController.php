<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DictionaryBrand\DictionaryBrandCollection;
use App\Services\DictionaryBrandService;
use Illuminate\Http\Request;

class DictionaryBrandController extends Controller
{
    protected DictionaryBrandService $dictionaryBrandService;
    public function __construct(DictionaryBrandService $dictionaryBrandService)
    {
        $this->dictionaryBrandService  =   $dictionaryBrandService;
    }

    public function list(): DictionaryBrandCollection
    {
        return new DictionaryBrandCollection($this->dictionaryBrandService->list());
    }
}
