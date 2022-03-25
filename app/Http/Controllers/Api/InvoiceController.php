<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceListRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceCollection;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Jobs\InvoiceCount;
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
    public function create(InvoiceCreateRequest $invoiceCreateRequest): InvoiceCollection
    {
        $data   =   $invoiceCreateRequest->check();
        $arr    =   [];
        foreach ($data[MainContract::DATA] as &$invoiceItem) {
            $arr[]  =   $this->invoiceService->create($invoiceItem);
        }
        InvoiceCount::dispatch($data[MainContract::RID]);
        return new InvoiceCollection($arr);
    }

    /**
     * @throws ValidationException
     */
    public function pagination(InvoiceListRequest $completionListRequest)
    {
        return $this->invoiceService->pagination($completionListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function all(InvoiceListRequest $completionListRequest): InvoiceCollection
    {
        return new InvoiceCollection($this->invoiceService->all($completionListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, InvoiceUpdateRequest $invoiceUpdateRequest): InvoiceResource|Response|Application|ResponseFactory
    {
        if ($invoice = $this->invoiceService->update($id,$invoiceUpdateRequest->check())) {
            InvoiceCount::dispatch($invoice->{MainContract::RID});
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

    public function getByRid($rid): InvoiceCollection
    {
        return new InvoiceCollection($this->invoiceService->getByRid($rid));
    }

}
