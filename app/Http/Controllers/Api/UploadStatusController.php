<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UploadStatus\UploadStatusCollection;
use App\Services\UploadStatusService;
use Illuminate\Http\Request;

class UploadStatusController extends Controller
{
    protected UploadStatusService $uploadStatusService;
    public function __construct(UploadStatusService $uploadStatusService)
    {
        $this->uploadStatusService  =   $uploadStatusService;
    }

    public function list(): UploadStatusCollection
    {
        return new UploadStatusCollection($this->uploadStatusService->list());
    }



}
