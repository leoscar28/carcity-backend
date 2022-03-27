<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Completion\CompletionCreateRequest;
use App\Http\Requests\Completion\CompletionListRequest;
use App\Http\Requests\Completion\CompletionUpdateRequest;
use App\Http\Resources\Completion\CompletionCollection;
use App\Http\Resources\Completion\CompletionResource;
use App\Http\Resources\CompletionDate\CompletionDateCollection;
use App\Jobs\CompletionCount;
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CompletionController extends Controller
{
    protected CompletionService $completionService;
    protected CompletionDateService $completionDateService;
    public function __construct(CompletionService $completionService, CompletionDateService $completionDateService)
    {
        $this->completionService    =   $completionService;
        $this->completionDateService    =   $completionDateService;
    }

    /**
     * @throws ValidationException
     */
    public function create(CompletionCreateRequest $completionCreateRequest): CompletionCollection
    {
        $data   =   $completionCreateRequest->check();
        $arr    =   [];
        foreach ($data[MainContract::DATA] as &$completionItem) {
            $arr[]  =   $this->completionService->create($completionItem);
        }
        CompletionCount::dispatch($data[MainContract::RID]);
        return new CompletionCollection($arr);
    }

    /**
     * @throws ValidationException
     */
    public function pagination(CompletionListRequest $completionListRequest)
    {
        return $this->completionService->pagination($completionListRequest->check());
    }

    /**
     * @throws ValidationException
     */
    public function all(CompletionListRequest $completionListRequest): CompletionCollection
    {
        return new CompletionCollection($this->completionService->all($completionListRequest->check()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, CompletionUpdateRequest $completionUpdateRequest): Response|CompletionResource|Application|ResponseFactory
    {
        if ($completion = $this->completionService->update($id,$completionUpdateRequest->check())) {
            CompletionCount::dispatch($completion->{MainContract::RID});
            return new CompletionResource($completion);
        }
        return response(['message'  =>  'Completion not found'],404);
    }

    public function getById($id): Response|CompletionResource|Application|ResponseFactory
    {
        if ($completion = $this->completionService->getById($id)) {
            return new CompletionResource($completion);
        }
        return response(['message'  =>  'Completion not found'],404);
    }

    public function getByRid($rid): CompletionCollection
    {
        return new CompletionCollection($this->completionService->getByRid($rid));
    }

    public function delete($rid,$id)
    {
        $this->completionService->update($id,[
            MainContract::STATUS    =>  0
        ]);
        CompletionCount::dispatch($rid);
    }

}
