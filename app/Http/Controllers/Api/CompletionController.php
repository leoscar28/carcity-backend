<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Helpers\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\Completion\CompletionCreateRequest;
use App\Http\Requests\Completion\CompletionDownloadByIdsRequest;
use App\Http\Requests\Completion\CompletionDownloadRequest;
use App\Http\Requests\Completion\CompletionListRequest;
use App\Http\Requests\Completion\CompletionUpdateRequest;
use App\Http\Resources\Completion\CompletionCollection;
use App\Http\Resources\Completion\CompletionResource;
use App\Http\Resources\CompletionDate\CompletionDateCollection;
use App\Jobs\CompletionCount;
use App\Jobs\CompletionFileCache;
use App\Jobs\CompletionTenant;
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CompletionController extends Controller
{
    protected CompletionService $completionService;
    protected CompletionDateService $completionDateService;
    protected File $file;
    public function __construct(CompletionService $completionService, CompletionDateService $completionDateService, File $file)
    {
        $this->completionService    =   $completionService;
        $this->completionDateService    =   $completionDateService;
        $this->file =   $file;
    }

    /**
     * @throws ValidationException
     */
    public function downloadByIds(CompletionDownloadByIdsRequest $completionDownloadByIdsRequest): Response|Application|ResponseFactory
    {
        $completions    =   $this->completionService->getByIds($completionDownloadByIdsRequest->check()[MainContract::IDS]);
        return $this->getCompletion($completions);
    }

    public function downloadAll($rid): Response|Application|ResponseFactory
    {
        $completions    =   $this->completionService->getByRid($rid);
        return $this->getCompletion($completions);
    }

    /**
     * @throws ValidationException
     */
    public function download(CompletionDownloadRequest $completionDownloadRequest): Response|Application|ResponseFactory
    {
        $data   =   $completionDownloadRequest->check();
        if ($completion = $this->completionService->getById($data[MainContract::ID])) {
            if ($data[MainContract::LINK] = $this->file->completionPath($completion)) {
                return response([MainContract::DATA =>  $data],200);
            }
            return response(['message'  =>  'Файл не найден или еще не загружен на сервер'],404);
        }
        return response(['message'  =>  'Запись не найдена'],404);
    }

    /**
     * @throws ValidationException
     */
    public function create(CompletionCreateRequest $completionCreateRequest): CompletionCollection
    {
        $data   =   $completionCreateRequest->check();
        $arr    =   [];
        foreach ($data[MainContract::DATA] as &$completionItem) {
            $completion =   $this->completionService->create($completionItem);
            CompletionFileCache::dispatch($completion);
            $arr[]      =   $completion;
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
        $completion = $this->completionService->update($id,$completionUpdateRequest->check());
        if ($completion) {
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

    /**
     * @param $completions
     * @return Application|ResponseFactory|Response
     */
    public function getCompletion($completions): ResponseFactory|Application|Response
    {
        if (sizeof($completions) > 0) {
            $arr = [];
            foreach ($completions as &$completion) {
                if ($file = $this->file->completionPath($completion)) {
                    $arr[]  =   $file;
                }
            }
            if (sizeof($arr) > 0) {
                return response([MainContract::DATA => $arr], 200);
            }
            return response(['message' => 'Документы не найдены'], 404);
        }
        return response(['message' => 'Запись не найдена'], 404);
    }

}
