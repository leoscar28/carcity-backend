<?php

namespace App\Services;

use App\Domain\Repositories\DictionaryBrand\DictionaryBrandRepositoryInterface;

class DictionaryBrandService
{
    protected DictionaryBrandRepositoryInterface $dictionaryBrandRepository;
    public function __construct(DictionaryBrandRepositoryInterface $dictionaryBrandRepository)
    {
        $this->dictionaryBrandRepository   =   $dictionaryBrandRepository;
    }

    public function list()
    {
        return $this->dictionaryBrandRepository->list();
    }
}
