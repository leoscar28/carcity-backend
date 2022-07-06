<?php

namespace App\Services;

use App\Domain\Repositories\DictionaryService\DictionaryServiceRepositoryInterface;

class DictionaryServiceService
{
    protected DictionaryServiceRepositoryInterface $dictionaryServiceRepository;
    public function __construct(DictionaryServiceRepositoryInterface $dictionaryServiceRepository)
    {
        $this->dictionaryServiceRepository   =   $dictionaryServiceRepository;
    }

    public function list()
    {
        return $this->dictionaryServiceRepository->list();
    }
}
