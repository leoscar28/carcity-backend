<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Services\InvoiceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService   =   $invoiceService;
    }

    /**
     * @throws ValidationException
     */
    public function create(InvoiceCreateRequest $invoiceCreateRequest): InvoiceResource
    {
        return new InvoiceResource($this->invoiceService->create($invoiceCreateRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, InvoiceUpdateRequest $invoiceUpdateRequest): InvoiceResource|Response|Application|ResponseFactory
    {
        if ($invoice = $this->invoiceService->update($id,$invoiceUpdateRequest->check())) {
            return new InvoiceResource($invoice);
        }
        return response(['message'  =>  'Invoice not found'],404);
    }

    public function getById($id): InvoiceResource|Response|Application|ResponseFactory
    {
        if ($invoice = $this->invoiceService->getById($id)) {
            return new InvoiceResource($invoice);
        }
        return response(['message'  =>  'Invoice not found'],404);
    }
}
