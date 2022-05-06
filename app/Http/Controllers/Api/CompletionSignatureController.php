<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
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
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use App\Services\CompletionSignatureService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CompletionSignatureController extends Controller
{
    protected CompletionSignatureService $completionSignatureService;
    protected CompletionService $completionService;
    protected UserService $userService;
    protected CompletionDateService $completionDateService;

    public function __construct(CompletionSignatureService $completionSignatureService,CompletionService $completionService, UserService $userService, CompletionDateService $completionDateService)
    {
        $this->completionSignatureService   =   $completionSignatureService;
        $this->completionService    =   $completionService;
        $this->userService  =   $userService;
        $this->completionDateService    =   $completionDateService;
    }

    public function multipleStart($rid,$userId): Response|Application|ResponseFactory
    {
        $completions    =   $this->completionService->getByRidAndUploadStatusId($rid,1);
        if (sizeof($completions) > 0) {
            $arr    =   [];
            foreach ($completions as &$completion) {
                if (!$this->completionSignatureService->getByCompletionIdAndUserId($completion->{MainContract::ID},$userId)) {
                    if (Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'.pdf')) {
                        $arr[]  =   [
                            MainContract::ID    =>  $completion->{MainContract::ID},
                            MainContract::DATA  =>  base64_encode(Storage::disk('public')->get($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'.pdf'))
                        ];
                    } else if (Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/'.$completion->{MainContract::ID}.'.pdf')) {
                        $arr[]  =   [
                            MainContract::ID    =>  $completion->{MainContract::ID},
                            MainContract::DATA  =>  base64_encode(Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/'.$completion->{MainContract::ID}.'.pdf'))
                        ];
                    }
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
            if ($completion = $this->completionService->getById($id)) {
                if (Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'.pdf')) {
                    return [MainContract::DATA  =>  base64_encode(Storage::disk('public')->get($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'.pdf'))];
                } else if (Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/'.$completion->{MainContract::ID}.'.pdf')) {
                    return [MainContract::DATA  =>  base64_encode(Storage::disk('public')->exists($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/'.$completion->{MainContract::ID}.'.pdf'))];
                }
            }
            return response(['message'  =>  'Запись не найдена'],404);
        }
        return response(['message'  =>  'Документ уже подписан'],400);
    }

    public function verifyData($signature)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "14579",
            CURLOPT_URL => "http://127.0.0.1:14579/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"version\": \"1.0\",\n    \"method\": \"XML.verify\",\n    \"params\": {\n        \"xml\":\"".addslashes($signature)."\"\n    }\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 7cba8c1b-29d5-5728-868f-26a35b218aa8"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return json_decode($response,true);
        }
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
                    if (!$this->completionSignatureService->getByCompletionIdAndUserId($completion->{MainContract::ID},$data[MainContract::USER_ID])) {
                        if ($verifiedData = $this->verifyData($data[MainContract::SIGNATURE][$key])) {
                            if (array_key_exists(MainContract::RESULT,$verifiedData)) {
                                $this->completionSignatureService->create([
                                    MainContract::COMPLETION_ID =>  $completion->{MainContract::ID},
                                    MainContract::USER_ID   =>  $data[MainContract::USER_ID],
                                    MainContract::SIGNATURE =>  $data[MainContract::SIGNATURE][$key],
                                    MainContract::DATA  =>  json_encode($verifiedData[MainContract::RESULT])
                                ]);
                            }
                            CompletionFiles::dispatch($completion,$user,$data[MainContract::SIGNATURE][$key],$verifiedData[MainContract::RESULT]);
                            $completion->{MainContract::UPLOAD_STATUS_ID}  =   2;
                            $completion->save();
                            CompletionTenant::dispatch($completion,2);
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
        if ($completion = $this->completionService->getById($data[MainContract::ID])) {
            if ($user   =   $this->userService->getById($data[MainContract::USER_ID])) {
                if (!$this->completionSignatureService->getByCompletionIdAndUserId($data[MainContract::ID],$data[MainContract::USER_ID])) {
                    if ($verifiedData = $this->verifyData($data[MainContract::SIGNATURE])) {
                        if (array_key_exists(MainContract::RESULT,$verifiedData)) {
                            if ((strtotime($verifiedData[MainContract::RESULT]['cert']['notAfter']) - time()) > 0) {
                                $this->completionSignatureService->create([
                                    MainContract::COMPLETION_ID    =>  $data[MainContract::ID],
                                    MainContract::USER_ID   =>  $data[MainContract::USER_ID],
                                    MainContract::SIGNATURE =>  $data[MainContract::SIGNATURE],
                                    MainContract::DATA  =>  json_encode($verifiedData[MainContract::RESULT])
                                ]);
                                if ($data[MainContract::ROLE_ID] === 4) {
                                    CompletionFiles::dispatch($completion,$user,$data[MainContract::SIGNATURE],$verifiedData[MainContract::RESULT]);
                                    $completion->{MainContract::UPLOAD_STATUS_ID}  =   2;
                                } else {
                                    CompletionTenantFiles::dispatch($completion,$user,$data[MainContract::SIGNATURE]);
                                    $completion->{MainContract::UPLOAD_STATUS_ID}  =   3;
                                }
                                $completion->save();
                                CompletionCount::dispatch($completion->{MainContract::RID});
                                return new CompletionResource($completion);
                            }
                            return response(['message'  =>  'Истек срок годности ключа'],400);
                        }
                    }
                    return response(['message'  =>  'Подпись не прошла валидацию'],400);
                }
                return response(['message'  =>  'Документ уже подписан'],400);
            }
            return response(['message'  =>  'Пользователь не найден'],404);
        }
        return response(['message'  =>  'Запись не найдена'],404);
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
