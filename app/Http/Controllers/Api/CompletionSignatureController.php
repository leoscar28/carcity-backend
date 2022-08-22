<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Helpers\Curl;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompletionSignature\CompletionSignatureCreateRequest;
use App\Http\Requests\CompletionSignature\CompletionSignatureMultipleCreateRequest;
use App\Http\Requests\CompletionSignature\CompletionSignatureUpdateRequest;
use App\Http\Resources\Completion\CompletionResource;
use App\Http\Resources\CompletionDate\CompletionDateResource;
use App\Http\Resources\CompletionSignature\CompletionSignatureCollection;
use App\Http\Resources\CompletionSignature\CompletionSignatureResource;
use App\Jobs\CompletionCount;
use App\Jobs\CompletionFiles;
use App\Jobs\CompletionTenant;
use App\Jobs\CompletionTenantFiles;
use App\Models\Completion;
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use App\Services\CompletionSignatureService;
use App\Services\UserBinService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Helpers\File;

class CompletionSignatureController extends Controller
{
    protected CompletionSignatureService $completionSignatureService;
    protected CompletionService $completionService;
    protected UserService $userService;
    protected CompletionDateService $completionDateService;
    protected UserBinService $userBinService;
    protected File $file;
    protected Curl $curl;

    public function __construct(CompletionSignatureService $completionSignatureService,CompletionService $completionService, UserService $userService, CompletionDateService $completionDateService, UserBinService $userBinService, File $file, Curl $curl)
    {
        $this->completionSignatureService   =   $completionSignatureService;
        $this->completionService    =   $completionService;
        $this->userService  =   $userService;
        $this->completionDateService    =   $completionDateService;
        $this->userBinService   =   $userBinService;
        $this->file =   $file;
        $this->curl =   $curl;
    }

    public function multipleStart($rid,$userId): Response|Application|ResponseFactory
    {        
        ini_set('max_execution_time', 600);
        
        $completions    =   $this->completionService->getByRidAndUploadStatusId($rid,1);
        if (sizeof($completions) > 0) {
            $arr    =   [];
            foreach ($completions as &$completion) {
                if (!$this->completionSignatureService->getByCompletionIdAndUserId($completion->{MainContract::ID},$userId) && $file = $this->file->completion($completion)) {
                    $arr[]  =   [
                        MainContract::ID    =>  $completion->{MainContract::ID},
                        MainContract::DATA  =>  $file
                    ];
                }
            }
            if (sizeof($arr) !== 0) {
                return response(['data'  =>  $arr],200);
            }
        }
        return response(['message'  =>  'Запись не найдено'],404);
    }

    public function start($id,$userId): Response|array|Application|ResponseFactory
    {
        if (!$this->completionSignatureService->getByCompletionIdAndUserId($id,$userId)) {
            if ($file = $this->file->completion($this->completionService->getById($id))) {
                return [MainContract::DATA  =>  $file];
            }
            return response(['message'  =>  'Запись не найдена'],404);
        }
        return response(['message'  =>  'Документ уже подписан'],400);
    }

    public function signatureCheck($verifiedData, $user): bool
    {
        $subject    =   $verifiedData[MainContract::RESULT][MainContract::CERT][MainContract::CHAIN][0][MainContract::SUBJECT];
        $iin    =   null;
        $bin    =   null;

        if (array_key_exists(MainContract::BIN,$subject)) {
            $bin    =   (int) $subject[MainContract::BIN];
            if ((int) $subject[MainContract::BIN] === (int) $user->{MainContract::BIN}) {
                return true;
            }
        }

        if (array_key_exists(MainContract::IIN,$subject)) {
            $iin    =   (int) $subject[MainContract::IIN];
            if ((int) $subject[MainContract::IIN] === (int) $user->{MainContract::BIN}) {
                return true;
            }
        }

        $bins   =   $this->userBinService->getByIin($user->{MainContract::BIN});
        foreach ($bins as &$users) {
            $userIin   =   (int)$users->{MainContract::BIN};
            if ($userIin === $iin || $userIin === $bin) {
                return true;
            }
        }
        return false;
    }

    public function createCheckMultiple($completion, $verifiedData, $data, $user, $key): bool
    {
        try {
            if ($this->signatureCheck($verifiedData, $user)) {
                $this->completionSignatureService->create([
                    MainContract::COMPLETION_ID =>  $completion->{MainContract::ID},
                    MainContract::USER_ID   =>  $data[MainContract::USER_ID],
                    MainContract::SIGNATURE =>  $data[MainContract::SIGNATURE][$key],
                    MainContract::DATA  =>  json_encode($verifiedData[MainContract::RESULT])
                ]);
                CompletionFiles::dispatch($completion,$user,$data[MainContract::SIGNATURE][$key],$verifiedData[MainContract::RESULT]);
                CompletionTenant::dispatch($completion,1);
                $completion->{MainContract::UPLOAD_STATUS_ID}  =   2;
                $completion->save();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createCheck($completion, $verifiedData, $data, $user): bool|Completion
    {
        if ($this->signatureCheck($verifiedData, $user)) {
            $this->completionSignatureService->create([
                MainContract::COMPLETION_ID    =>  $data[MainContract::ID],
                MainContract::USER_ID   =>  $data[MainContract::USER_ID],
                MainContract::SIGNATURE =>  $data[MainContract::SIGNATURE],
                MainContract::DATA  =>  json_encode($verifiedData[MainContract::RESULT])
            ]);
            if ($data[MainContract::ROLE_ID] === 4) {
                CompletionFiles::dispatch($completion,$user,$data[MainContract::SIGNATURE],$verifiedData[MainContract::RESULT]);
                CompletionTenant::dispatch($completion,1);
                $completion->{MainContract::UPLOAD_STATUS_ID}  =   2;
            } else {
                CompletionTenantFiles::dispatch($completion,$user,$data[MainContract::SIGNATURE],$verifiedData[MainContract::RESULT]);
                $completion->{MainContract::UPLOAD_STATUS_ID}  =   3;
                $completion->{MainContract::FILE}   =   null;
            }
            $completion->save();
            CompletionCount::dispatch($completion->{MainContract::RID});
            return $completion;
        }
        return false;
    }

    /**
     * @throws ValidationException
     */
    public function multipleCreate(CompletionSignatureMultipleCreateRequest $completionSignatureMultipleCreateRequest): Response|CompletionDateResource|Application|ResponseFactory
    {
        $data   =   $completionSignatureMultipleCreateRequest->check();
        if ($user = $this->userService->getById($data[MainContract::USER_ID])) {
            foreach ($data[MainContract::RES] as $key => $result) {
                if ($completion = $this->completionService->getById($result[MainContract::ID])) {
                    if (!$this->completionSignatureService->getByCompletionIdAndUserId($completion->{MainContract::ID},$data[MainContract::USER_ID]) && $verifiedData = $this->curl->verifyData($data[MainContract::SIGNATURE][$key])) {
                        if (!$this->createCheckMultiple($completion, $verifiedData, $data, $user, $key)) {
                            return response(['message'  =>  'Этим ЭЦП ключом нельзя подписать, обратитесть к администратору'],400);
                        }
                    }
                }
            }
            CompletionCount::dispatch($data[MainContract::RID]);
            if ($completionDate = $this->completionDateService->getByRid($data[MainContract::RID])) {
                return new completionDateResource($completionDate);
            }
            return response(['message'  =>  'Запись не найдена'],404);
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    /**
     * @throws ValidationException
     */
    public function create(CompletionSignatureCreateRequest $completionSignatureCreateRequest): Response|CompletionResource|Application|ResponseFactory
    {
        $data   =   $completionSignatureCreateRequest->check();

        if (!$completion = $this->completionService->getById($data[MainContract::ID])) {
            return response(['message'  =>  'Запись не найдена'],404);
        }

        if (!$user = $this->userService->getById($data[MainContract::USER_ID])) {
            return response(['message'  =>  'Пользователь не найден'],404);
        }

        if ($this->completionSignatureService->getByCompletionIdAndUserId($data[MainContract::ID],$data[MainContract::USER_ID])) {
            return response(['message'  =>  'Документ уже подписан'],400);
        }

        if (!$verifiedData = $this->curl->verifyData($data[MainContract::SIGNATURE])) {
            return response(['message'  =>  'Подпись не прошла валидацию'],400);
        }

        if (!array_key_exists(MainContract::RESULT,$verifiedData)) {
            return response(['message'  =>  'Подпись не прошла валидацию'],400);
        }

        if ((strtotime($verifiedData[MainContract::RESULT][MainContract::CERT][MainContract::NOT_AFTER]) - time()) < 0) {
            return response(['message'  =>  'Истек срок годности ключа'],400);
        }

        if ($completion = $this->createCheck($completion, $verifiedData, $data, $user)) {
            return new CompletionResource($completion);
        }

        return response(['message'  =>  'Этим ЭЦП ключом нельзя подписать, обратитесть к администратору'],400);

    }

    /**
     * @throws ValidationException
     */
    public function update($id, CompletionSignatureUpdateRequest $completionSignatureUpdateRequest): Response|CompletionSignatureResource|Application|ResponseFactory
    {
        if ($completion =   $this->completionSignatureService->update($id,$completionSignatureUpdateRequest->check())) {
            return new CompletionSignatureResource($completion);
        }
        return response(['message'  =>  'CompletionSignature not found'],404);
    }

    public function getByCompletionId($id): CompletionSignatureCollection
    {
        return new CompletionSignatureCollection($this->completionSignatureService->getByCompletionId($id));
    }
}
