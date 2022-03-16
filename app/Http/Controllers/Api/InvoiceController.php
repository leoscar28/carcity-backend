<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Services\InvoiceService;
use App\Services\InvoiceListService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;
    protected InvoiceListService $invoiceListService;
    public function __construct(InvoiceService $invoiceService,InvoiceListService $invoiceListService)
    {
        $this->invoiceService   =   $invoiceService;
        $this->invoiceListService   =   $invoiceListService;
    }

    /**
     * @throws ValidationException
     */
    public function create(InvoiceCreateRequest $invoiceCreateRequest): InvoiceResource
    {
        $data   =   $invoiceCreateRequest->check()[MainContract::DATA];
        $invoice    =   $this->invoiceService->create([
            MainContract::UPLOAD_STATUS_ID  =>  1,
            MainContract::DOCUMENT_ALL  =>  sizeof($data),
        ]);

        foreach ($data as &$invoiceItem) {
            $this->invoiceListService->create([
                MainContract::INVOICE_ID    =>  $invoice->{MainContract::ID},
                MainContract::CUSTOMER  =>  $invoiceItem[MainContract::CUSTOMER]??NULL,
                MainContract::CUSTOMER_ID   =>  $invoiceItem[MainContract::CUSTOMER_ID]??NULL,
                MainContract::NUMBER    =>  $invoiceItem[MainContract::NUMBER]??NULL,
                MainContract::ORGANIZATION  =>  $invoiceItem[MainContract::ORGANIZATION]??NULL,
                MainContract::DATE  =>  $invoiceItem[MainContract::DATE]??NULL,
                MainContract::SUM   =>  $invoiceItem[MainContract::SUM]??NULL,
                MainContract::NAME  =>  $invoiceItem[MainContract::NAME]??NULL,
            ]);
        }

        return new InvoiceResource($this->invoiceService->getById($invoice->{MainContract::ID}));
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
