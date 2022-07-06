<?php

namespace App\Services;

use App\Domain\Repositories\DictionarySparePart\DictionarySparePartRepositoryInterface;

class DictionarySparePartService
{
    protected DictionarySparePartRepositoryInterface $dictionarySparePartRepository;
    public function __construct(DictionarySparePartRepositoryInterface $dictionarySparePartRepository)
    {
        $this->dictionarySparePartRepository   =   $dictionarySparePartRepository;
    }

    public function list()
    {
        return $this->dictionarySparePartRepository->list();
    }
}
