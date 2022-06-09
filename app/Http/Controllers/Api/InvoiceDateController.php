<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Events\InvoiceDateEvent;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceDate\InvoiceDateListRequest;
use App\Http\Requests\InvoiceDate\InvoiceDateUpdateRequest;
use App\Http\Resources\InvoiceDate\InvoiceDateCollection;
use App\Http\Resources\InvoiceDate\InvoiceDateResource;
use App\Http\Resources\InvoiceDate\InvoiceDateWithoutRelationCollection;
use App\Http\Resources\InvoiceDate\InvoiceDateWithoutRelationResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Jobs\DeleteInvoiceTenant;
use App\Services\InvoiceDateService;
use App\Services\InvoiceService;
use App\Services\NotificationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class InvoiceDateController extends Controller
{
    protected InvoiceDateService $invoiceDateService;
    protected InvoiceService $invoiceService;
    protected NotificationService $notificationService;
    public function __construct(InvoiceDateService $invoiceDateService, InvoiceService $invoiceService, notificationService $notificationService)
    {
        $this->invoiceDateService   =   $invoiceDateService;
        $this->invoiceService   =   $invoiceService;
        $this->notificationService  =   $notificationService;
    }

    /**
     * @throws ValidationException
     */
    public function pagination(InvoiceDateListRequest $invoiceDateListRequest)
    {
        $data   =   $invoiceDateListRequest->check();
        if (array_key_exists(MainContract::COMPANY,$data)||array_key_exists(MainContract::NUMBER,$data)) {
            return $this->invoiceService->paginationByCustomerAndNumber($data);
        }
        return $this->invoiceDateService->pagination($data);
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
    public function get(InvoiceDateListRequest $invoiceDateListRequest): InvoiceDateWithoutRelationCollection
    {
        $data   =   $invoiceDateListRequest->check();
        $invoiceDates   =   [];
        if (array_key_exists(MainContract::COMPANY,$data)||array_key_exists(MainContract::NUMBER,$data)) {
            $arr    =   [];
            $invoices   =   $this->invoiceService->getByCustomerAndNumber($data);
            foreach ($invoices as &$invoice) {
                if (!array_key_exists($invoice->{MainContract::RID},$arr)) {
                    $arr[$invoice->{MainContract::RID}] =   [
                        MainContract::PARENT    =>  $this->invoiceDateService->getByRid($invoice->{MainContract::RID}),
                        MainContract::CHILD     =>  []
                    ];
                }
                $arr[$invoice->{MainContract::RID}][MainContract::CHILD][]  =   $invoice;
            }
            foreach ($arr as &$item) {
                Log::info('invoice dates',[ $item[MainContract::PARENT]->{MainContract::RID}]);
                $item[MainContract::PARENT]->{MainContract::RIDS}   =   $item[MainContract::CHILD];
                $invoiceDates[] =   $item[MainContract::PARENT];
            }
        } else {
            $invoiceDates   =   $this->invoiceDateService->get($data);
        }
        return new InvoiceDateWithoutRelationCollection($invoiceDates);
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

    public function delete($rid)
    {
        if ($invoiceDate = $this->invoiceDateService->getByRid($rid)) {
            $invoiceDate->{MainContract::STATUS}    =   0;
            $invoiceDate->save();
            $notifications  =   $this->notificationService->getByData([
                MainContract::INVOICE_ID    =>  $invoiceDate->{MainContract::ID},
            ]);
            foreach ($notifications as &$notification) {
                $notification->{MainContract::STATUS}   =   0;
                $notification->save();
                event(new NotificationEvent(New NotificationResource($notification)));
            }
            event(new InvoiceDateEvent(new InvoiceDateWithoutRelationResource($invoiceDate)));
        }
        DeleteInvoiceTenant::dispatch($rid);
    }
}
