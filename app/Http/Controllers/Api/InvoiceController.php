<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceDownloadRequest;
use App\Http\Requests\Invoice\InvoiceListRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceCollection;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Jobs\InvoiceCount;
use App\Jobs\InvoiceTenant;
use App\Services\InvoiceService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService   =   $invoiceService;
    }

    public function downloadAll($rid): Response|Application|ResponseFactory
    {
        $completions    =   $this->invoiceService->getByRid($rid);
        if (sizeof($completions) > 0) {
            $arr    =   [];
            foreach ($completions as &$completion) {
                if (Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/invoices/'.$completion->{MainContract::ID}.'.pdf')) {
                    $arr[]  =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$completion->{MainContract::CUSTOMER_ID}.'/invoices/'.$completion->{MainContract::ID}.'.pdf';
                }
            }
            if (sizeof($arr) > 0) {
                return response([MainContract::DATA =>  $arr],200);
            }
            return response(['message'  =>  'Документы не найдены'],404);
        }
        return response(['message'  =>  'Запись не найдена'],404);
    }

    /**
     * @throws ValidationException
     */
    public function download(InvoiceDownloadRequest $invoiceDownloadRequest): Response|Application|ResponseFactory
    {
        $data   =   $invoiceDownloadRequest->check();
        if ($invoice = $this->invoiceService->getById($data[MainContract::ID])) {
            if (Storage::disk('public')->exists($invoice->{MainContract::CUSTOMER_ID}.'/invoices/'.$invoice->{MainContract::ID}.'.pdf')) {
                if ($data[MainContract::STATUS]) {
                    $invoice->{MainContract::UPLOAD_STATUS_ID}  =   2;
                    $invoice->save();
                    InvoiceCount::dispatch($data[MainContract::RID]);
                }
                $data[MainContract::LINK]   =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$invoice->{MainContract::CUSTOMER_ID}.'/invoices/'.$invoice->{MainContract::ID}.'.pdf';
                return response([MainContract::DATA =>  $data],200);
            }
            return response(['message'  =>  'Файл не найден или еще не загружен на сервер'],404);
        }
        return response(['message'  =>  'Счет на оплату не найден'],404);
    }

    /**
     * @throws ValidationException
     */
    public function create(InvoiceCreateRequest $invoiceCreateRequest): InvoiceCollection
    {
        $data   =   $invoiceCreateRequest->check();
        $arr    =   [];
        foreach ($data[MainContract::DATA] as &$invoiceItem) {
            $invoice    =   $this->invoiceService->create($invoiceItem);
            InvoiceTenant::dispatch($invoice);
            $arr[]  =   $invoice;
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
        $invoice = $this->invoiceService->update($id,$invoiceUpdateRequest->check());
        if ($invoice) {
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

    public function delete($rid,$id)
    {
        $this->invoiceService->update($id,[
            MainContract::STATUS    =>  0
        ]);
        InvoiceCount::dispatch($rid);
    }

}
