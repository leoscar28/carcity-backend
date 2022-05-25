<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationSignature\ApplicationSignatureCreateRequest;
use App\Http\Requests\ApplicationSignature\ApplicationSignatureMultipleCreateRequest;
use App\Http\Requests\ApplicationSignature\ApplicationSignatureUpdateRequest;
use App\Http\Resources\Application\ApplicationResource;
use App\Http\Resources\ApplicationDate\ApplicationDateResource;
use App\Http\Resources\ApplicationSignature\ApplicationSignatureCollection;
use App\Http\Resources\ApplicationSignature\ApplicationSignatureResource;
use App\Jobs\ApplicationCount;
use App\Jobs\ApplicationFiles;
use App\Jobs\ApplicationSignatureArchive;
use App\Jobs\ApplicationTenant;
use App\Jobs\ApplicationTenantFiles;
use App\Services\ApplicationDateService;
use App\Services\ApplicationService;
use App\Services\ApplicationSignatureService;
use App\Services\UserBinService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ApplicationSignatureController extends Controller
{
    protected ApplicationSignatureService $applicationSignatureService;
    protected ApplicationService $applicationService;
    protected UserService $userService;
    protected ApplicationDateService $applicationDateService;
    protected UserBinService $userBinService;

    public function __construct(ApplicationSignatureService $applicationSignatureService, ApplicationService $applicationService, UserService $userService, ApplicationDateService $applicationDateService, UserBinService $userBinService)
    {
        $this->applicationSignatureService  =   $applicationSignatureService;
        $this->applicationService   =   $applicationService;
        $this->userService  =   $userService;
        $this->applicationDateService   =   $applicationDateService;
        $this->userBinService   =   $userBinService;
    }

    public function multipleStart($rid,$userId): Response|Application|ResponseFactory
    {
        $applications   =   $this->applicationService->getByRidAndUploadStatusId($rid,1);
        if (sizeof($applications) > 0) {
            $arr    =   [];
            foreach ($applications as &$application) {
                if (!$this->applicationSignatureService->getByApplicationIdAndUserId($application->{MainContract::ID},$userId)) {
                    if (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx')) {
                        $arr[]  =   [
                            MainContract::ID    =>  $application->{MainContract::ID},
                            MainContract::DATA  =>  base64_encode(Storage::disk('public')->get($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx'))
                        ];
                    } else if (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx')) {
                        $arr[]  =   [
                            MainContract::ID    =>  $application->{MainContract::ID},
                            MainContract::DATA  =>  base64_encode(Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx'))
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
        if (!$this->applicationSignatureService->getByApplicationIdAndUserId($id,$userId)) {
            if ($application = $this->applicationService->getById($id)) {
                if (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx')) {
                    return ['data'  =>  base64_encode(Storage::disk('public')->get($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'.docx'))];
                } else if (Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx')) {
                    return ['data'  =>  base64_encode(Storage::disk('public')->exists($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/'.$application->{MainContract::ID}.'.docx'))];
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
    public function multipleCreate(ApplicationSignatureMultipleCreateRequest $applicationSignatureMultipleCreateRequest): ApplicationDateResource|Response|Application|ResponseFactory
    {
        $data   =   $applicationSignatureMultipleCreateRequest->check();
        if ($user = $this->userService->getById($data[MainContract::USER_ID])) {
            foreach ($data[MainContract::RES] as $key => $result) {
                if ($application = $this->applicationService->getById($result[MainContract::ID])) {
                    if (!$this->applicationSignatureService->getByApplicationIdAndUserId($application->{MainContract::ID},$data[MainContract::USER_ID])) {
                        if ($verifiedData = $this->verifyData($data[MainContract::SIGNATURE][$key])) {
                            if (array_key_exists(MainContract::RESULT,$verifiedData)) {

                                $status =   false;
                                $subject    =   $verifiedData[MainContract::RESULT][MainContract::CERT][MainContract::CHAIN][0][MainContract::SUBJECT];
                                $iin    =   null;
                                $bin    =   null;
                                if (array_key_exists(MainContract::BIN,$subject)) {
                                    $bin    =   (int) $subject[MainContract::BIN];
                                    if ((int) $subject[MainContract::BIN] === (int) $user->{MainContract::BIN}) {
                                        $status =   true;
                                    }
                                }
                                if (array_key_exists(MainContract::IIN,$subject)) {
                                    $iin    =   (int) $subject[MainContract::IIN];
                                    if ((int) $subject[MainContract::IIN] === (int) $user->{MainContract::BIN}) {
                                        $status =   true;
                                    }
                                }

                                if (!$status) {
                                    $bins   =   $this->userBinService->getByIin($user->{MainContract::BIN});
                                    foreach ($bins as &$users) {
                                        $userIin   =   (int)$users->{MainContract::BIN};
                                        if ($userIin === $iin || $userIin === $bin) {
                                            $status =   true;
                                            break;
                                        }
                                    }
                                }

                                if ($status) {
                                    $this->applicationSignatureService->create([
                                        MainContract::APPLICATION_ID    =>  $application->{MainContract::ID},
                                        MainContract::USER_ID   =>  $data[MainContract::USER_ID],
                                        MainContract::SIGNATURE =>  $data[MainContract::SIGNATURE][$key],
                                        MainContract::DATA  =>  json_encode($verifiedData[MainContract::RESULT])
                                    ]);
                                    $application->{MainContract::UPLOAD_STATUS_ID}  =   2;
                                    $application->save();
                                    ApplicationFiles::dispatch($application,$user,$data[MainContract::SIGNATURE][$key]);
                                    ApplicationTenant::dispatch($application,1);
                                } else {
                                    return response(['message'  =>  'Этим ЭЦП ключом нельзя подписать, обратитесть к администратору'],400);
                                }
                            }
                        }
                    }
                }
            }
            ApplicationCount::dispatch($data[MainContract::RID]);
            if ($applicationDate = $this->applicationDateService->getByRid($data[MainContract::RID])) {
                return new ApplicationDateResource($applicationDate);
            }
            return response(['message'  =>  'Запись не найдена'],404);
        }
        return response(['message'  =>  'Пользователь не найден'],404);
    }

    /**
     * @throws ValidationException
     */
    public function create(ApplicationSignatureCreateRequest $applicationSignatureCreateRequest): Response|ApplicationResource|Application|ResponseFactory
    {
        $data   =   $applicationSignatureCreateRequest->check();
        if ($application = $this->applicationService->getById($data[MainContract::ID])) {
            if ($user   =   $this->userService->getById($data[MainContract::USER_ID])) {
                if (!$this->applicationSignatureService->getByApplicationIdAndUserId($data[MainContract::ID],$data[MainContract::USER_ID])) {
                    if ($verifiedData = $this->verifyData($data[MainContract::SIGNATURE])) {
                        if (array_key_exists(MainContract::RESULT,$verifiedData)) {
                            if ((strtotime($verifiedData[MainContract::RESULT]['cert']['notAfter']) - time()) > 0) {
                                $status =   false;
                                $subject    =   $verifiedData[MainContract::RESULT][MainContract::CERT][MainContract::CHAIN][0][MainContract::SUBJECT];
                                $iin    =   null;
                                $bin    =   null;
                                if (array_key_exists(MainContract::BIN,$subject)) {
                                    $bin    =   (int) $subject[MainContract::BIN];
                                    if ((int) $subject[MainContract::BIN] === (int) $user->{MainContract::BIN}) {
                                        $status =   true;
                                    }
                                }
                                if (array_key_exists(MainContract::IIN,$subject)) {
                                    $iin    =   (int) $subject[MainContract::IIN];
                                    if ((int) $subject[MainContract::IIN] === (int) $user->{MainContract::BIN}) {
                                        $status =   true;
                                    }
                                }
                                if (!$status) {
                                    $bins   =   $this->userBinService->getByIin($user->{MainContract::BIN});
                                    foreach ($bins as &$users) {
                                        $userIin   =   (int)$users->{MainContract::BIN};
                                        if ($userIin === $iin || $userIin === $bin) {
                                            $status =   true;
                                            break;
                                        }
                                    }
                                }
                                if ($status) {
                                    $this->applicationSignatureService->create([
                                        MainContract::APPLICATION_ID    =>  $data[MainContract::ID],
                                        MainContract::USER_ID   =>  $data[MainContract::USER_ID],
                                        MainContract::SIGNATURE =>  $data[MainContract::SIGNATURE],
                                        MainContract::DATA  =>  json_encode($verifiedData[MainContract::RESULT])
                                    ]);
                                    if ($data[MainContract::ROLE_ID] === 4) {
                                        $application->{MainContract::UPLOAD_STATUS_ID}  =   2;
                                        ApplicationFiles::dispatch($application,$user,$data[MainContract::SIGNATURE]);
                                        ApplicationTenant::dispatch($application,1);
                                    } else {
                                        ApplicationTenantFiles::dispatch($application,$user,$data[MainContract::SIGNATURE]);
                                        $application->{MainContract::UPLOAD_STATUS_ID}  =   3;
                                    }
                                    $application->save();
                                    ApplicationCount::dispatch($application->{MainContract::RID});
                                    return new ApplicationResource($application);
                                }
                                return response(['message'  =>  'Этим ЭЦП ключом нельзя подписать, обратитесть к администратору'],400);
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
    public function update($id, ApplicationSignatureUpdateRequest $applicationSignatureUpdateRequest): Response|ApplicationSignatureResource|Application|ResponseFactory
    {
        if ($application    =   $this->applicationSignatureService->update($id,$applicationSignatureUpdateRequest->check())) {
            return new ApplicationSignatureResource($application);
        }
        return response(['message'  =>  'ApplicationSignature not found'],404);
    }

    public function getByApplicationId($id): ApplicationSignatureCollection
    {
        return new ApplicationSignatureCollection($this->applicationSignatureService->getByApplicationId($id));
    }
}
