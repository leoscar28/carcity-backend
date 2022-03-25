<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceDate\InvoiceDateListRequest;
use App\Http\Requests\InvoiceDate\InvoiceDateUpdateRequest;
use App\Http\Resources\InvoiceDate\InvoiceDateCollection;
use App\Http\Resources\InvoiceDate\InvoiceDateResource;
use App\Services\InvoiceDateService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class InvoiceDateController extends Controller
{
    protected InvoiceDateService $invoiceDateService;
    public function __construct(InvoiceDateService $invoiceDateService)
    {
        $this->invoiceDateService   =   $invoiceDateService;
    }

    /**
     * @throws ValidationException
     */
    public function pagination(InvoiceDateListRequest $invoiceDateListRequest)
    {
        return $this->invoiceDateService->pagination($invoiceDateListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function list(InvoiceDateListRequest $invoiceDateListRequest): InvoiceDateCollection
    {
        return new InvoiceDateCollection($this->invoiceDateService->list($invoiceDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, InvoiceDateUpdateRequest $invoiceDateUpdateRequest): Response|InvoiceDateResource|Application|ResponseFactory
    {
        if ($invoiceDate = $this->invoiceDateService->update($id,$invoiceDateUpdateRequest->check())) {
            return new InvoiceDateResource($invoiceDate);
        }
        return response(['message'  =>  'InvoiceDate not found'],404);
    }

    public function getByRid($rid): Response|InvoiceDateResource|Application|ResponseFactory
    {
        if ($invoiceDate = $this->invoiceDateService->getByRid($rid)) {
            return new invoiceDateResource($invoiceDate);
        }
        return response(['message'  =>  'InvoiceDate not found'],404);
    }

    public function getById($id): Response|InvoiceDateResource|Application|ResponseFactory
    {
        if ($invoiceDate = $this->invoiceDateService->getById($id)) {
            return new InvoiceDateResource($invoiceDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }
}
