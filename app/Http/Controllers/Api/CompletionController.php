<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Completion\CompletionCreateRequest;
use App\Http\Requests\Completion\CompletionUpdateRequest;
use App\Http\Resources\Completion\CompletionResource;
use App\Services\CompletionService;
use App\Services\CompletionListService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CompletionController extends Controller
{
    protected CompletionService $completionService;
    protected CompletionListService $completionListService;
    public function __construct(CompletionService $completionService,CompletionListService $completionListService)
    {
        $this->completionService    =   $completionService;
        $this->completionListService    =   $completionListService;
    }

    /**
     * @throws ValidationException
     */
    public function create(CompletionCreateRequest $completionCreateRequest): CompletionResource
    {
        $data   =   $completionCreateRequest->check()[MainContract::DATA];
        $completion =   $this->completionService->create([
            MainContract::UPLOAD_STATUS_ID  =>  1,
            MainContract::DOCUMENT_ALL  =>  sizeof($data),
        ]);
        foreach ($data as &$completionItem) {
            $this->completionListService->create([
                MainContract::COMPLETION_ID    =>  $completion->{MainContract::ID},
                MainContract::CUSTOMER  =>  $completionItem[MainContract::CUSTOMER]??NULL,
                MainContract::CUSTOMER_ID   =>  $completionItem[MainContract::CUSTOMER_ID]??NULL,
                MainContract::NUMBER    =>  $completionItem[MainContract::NUMBER]??NULL,
                MainContract::ORGANIZATION  =>  $completionItem[MainContract::ORGANIZATION]??NULL,
                MainContract::DATE  =>  $completionItem[MainContract::DATE]??NULL,
                MainContract::SUM   =>  $completionItem[MainContract::SUM]??NULL,
                MainContract::NAME  =>  $completionItem[MainContract::NAME]??NULL,
            ]);
        }
        return new CompletionResource($this->completionService->getById($completion->{MainContract::ID}));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, CompletionUpdateRequest $completionUpdateRequest): Response|CompletionResource|Application|ResponseFactory
    {
        if ($completion = $this->completionService->update($id,$completionUpdateRequest->check())) {
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

}
