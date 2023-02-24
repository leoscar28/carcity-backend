<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceDownloadByIdsRequest;
use App\Http\Requests\Invoice\InvoiceDownloadRequest;
use App\Http\Requests\Invoice\InvoiceListRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Http\Resources\Invoice\InvoiceCollection;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Jobs\InvoiceCount;
use App\Jobs\InvoiceTenant;
use App\Services\InvoiceService;
use Exception;
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

    /**
     * @throws ValidationException
     */
    public function downloadByIds(InvoiceDownloadByIdsRequest $invoiceDownloadByIdsRequest): Response|Application|ResponseFactory
    {
        $invoices   =   $this->invoiceService->getByIds($invoiceDownloadByIdsRequest->check()[MainContract::IDS]);
        return $this->getInvoice($invoices);
    }

    public function getInvoice($invoices): Response|Application|ResponseFactory
    {
        if (sizeof($invoices) > 0) {
            $arr    =   [];
            foreach ($invoices as &$invoice) {
                if (Storage::disk('public')->exists($invoice->{MainContract::CUSTOMER_ID}.'/invoices/'.$invoice->{MainContract::ID}.'.pdf')) {
                    $arr[]  =   env('APP_URL','https://admin.car-city.kz').'/storage/'.$invoice->{MainContract::CUSTOMER_ID}.'/invoices/'.$invoice->{MainContract::ID}.'.pdf';
                }
            }
            if (sizeof($arr) > 0) {
                return response([MainContract::DATA =>  $arr],200);
            }
            return response(['message'  =>  'Документы не найдены'],404);
        }
        return response(['message'  =>  'Запись не найдена'],404);
    }

    public function downloadAll($rid): Response|Application|ResponseFactory
    {
        $invoices    =   $this->invoiceService->getByRid($rid);
        return $this->getInvoice($invoices);
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
        try {
            $data = $invoiceCreateRequest->check();
            $arr = [];
            foreach ($data[MainContract::DATA] as &$invoiceItem) {
                $invoice = $this->invoiceService->create($invoiceItem);
                InvoiceTenant::dispatch($invoice);
                $arr[] = $invoice;
            }
            InvoiceCount::dispatch($data[MainContract::RID]);
            file_put_contents('test.txt', $arr, FILE_APPEND | LOCK_EX);
            return new InvoiceCollection($arr);
        } catch(Exception $e) {
            file_put_contents('test.txt', $e->getMessage(), FILE_APPEND | LOCK_EX);
            return response(['message'  =>  $e->getMessage()],404);
        }
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
