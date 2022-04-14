<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompletionDate\CompletionDateListRequest;
use App\Http\Requests\CompletionDate\CompletionDateUpdateRequest;
use App\Http\Resources\CompletionDate\CompletionDateCollection;
use App\Http\Resources\CompletionDate\CompletionDateResource;
use App\Http\Resources\CompletionDate\CompletionDateWithoutRelationCollection;
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CompletionDateController extends Controller
{
    protected CompletionDateService $completionDateService;
    protected CompletionService $completionService;
    public function __construct(CompletionDateService $completionDateService, CompletionService $completionService)
    {
        $this->completionDateService    =   $completionDateService;
        $this->completionService    =   $completionService;
    }

    /**
     * @throws ValidationException
     */
    public function pagination(CompletionDateListRequest $completionDateListRequest)
    {
        return $this->completionDateService->pagination($completionDateListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function list(CompletionDateListRequest $completionDateListRequest): CompletionDateCollection
    {
        return new CompletionDateCollection($this->completionDateService->list($completionDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function get(CompletionDateListRequest $completionDateListRequest): CompletionDateWithoutRelationCollection
    {
        return new CompletionDateWithoutRelationCollection($this->completionDateService->get($completionDateListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, CompletionDateUpdateRequest $completionDateUpdateRequest): Response|CompletionDateResource|Application|ResponseFactory
    {
        if ($completionDate = $this->completionDateService->update($id,$completionDateUpdateRequest->check())) {
            return new CompletionDateResource($completionDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function getByRid($rid): Response|CompletionDateResource|Application|ResponseFactory
    {
        if ($completionDate = $this->completionDateService->getByRid($rid)) {
            return new CompletionDateResource($completionDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function getById($id): Response|CompletionDateResource|Application|ResponseFactory
    {
        if ($completionDate = $this->completionDateService->getById($id)) {
            return new CompletionDateResource($completionDate);
        }
        return response(['message'  =>  'CompletionDate not found'],404);
    }

    public function delete($rid)
    {
        $this->completionDateService->delete($rid);
        $this->completionService->delete($rid);
    }

}
