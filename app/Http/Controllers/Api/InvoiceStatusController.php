<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceStatus\InvoiceStatusCollection;
use App\Services\InvoiceStatusService;
use Illuminate\Http\Request;

class InvoiceStatusController extends Controller
{
    protected InvoiceStatusService $invoiceStatusService;
    public function __construct(InvoiceStatusService $invoiceStatusService)
    {
        $this->invoiceStatusService =   $invoiceStatusService;
    }

    public function list(): InvoiceStatusCollection
    {
        return new InvoiceStatusCollection($this->invoiceStatusService->list());
    }

}
