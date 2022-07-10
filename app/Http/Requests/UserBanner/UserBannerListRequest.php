<?php

namespace App\Http\Requests\UserBanner;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RoleContract;
use App\Domain\Contracts\UserBannerContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserBannerListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            MainContract::PAGINATION    =>  'nullable',
            MainContract::TAKE  =>  'nullable',
            MainContract::ROLE_ID   =>  'nullable',
            MainContract::USER_ID => 'nullable',
            MainContract::TYPE => 'nullable',
            MainContract::CREATED_AT => 'nullable',
            MainContract::DATA => 'nullable',
            MainContract::CATEGORY_ID => 'nullable',
            MainContract::BRAND_ID => 'nullable',
            MainContract::TERM => 'nullable',
            MainContract::WITH_IMAGE => 'nullable',
            MainContract::SORT => 'nullable',
            MainContract::ORDER_BY => 'nullable'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function check(): array
    {
        $data   =   $this->validator->validated();
        if (!array_key_exists(MainContract::PAGINATION,$data)) {
            $data[MainContract::PAGINATION] =   1;
        }

        if (!array_key_exists(MainContract::TAKE,$data)) {
            $data[MainContract::TAKE]   =   30;
        }

        if (array_key_exists(MainContract::USER_ID,$data)) {
            $data[MainContract::DATA][] =   [MainContract::USER_ID,$data[MainContract::USER_ID]];
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $date   =   explode('_',$data[MainContract::CREATED_AT]);
            $data[MainContract::CREATED_AT] =   [date('Y-m-d',strtotime($date[0])).' 00:00:00',date('Y-m-d',strtotime($date[1])).' 23:59:59'];
        }

        if (array_key_exists(MainContract::TYPE,$data)) {
           if ($data[MainContract::TYPE] === 'new') {
               $data[MainContract::STATUS] = [UserBannerContract::STATUS_CREATED, UserBannerContract::STATUS_UPDATED];
           } else if ($data[MainContract::TYPE] === 'inactive') {
               $data[MainContract::STATUS] = [UserBannerContract::STATUS_NOT_PUBLISHED, UserBannerContract::STATUS_INACTIVE];
           } else if ($data[MainContract::TYPE] === 'active') {
               $data[MainContract::STATUS] = [UserBannerContract::STATUS_NEED_EDITS, UserBannerContract::STATUS_PUBLISHED];
           } else if ($data[MainContract::TYPE] === 'published') {
               $data[MainContract::STATUS] = [UserBannerContract::STATUS_PUBLISHED];
           }
        } else {
            $data[MainContract::STATUS] = [UserBannerContract::STATUS_CREATED, UserBannerContract::STATUS_UPDATED, UserBannerContract::STATUS_NEED_EDITS, UserBannerContract::STATUS_PUBLISHED];
        }

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'failure',
            'status_code' => 400,
            'message' => 'Bad Request',
            'errors' => $validator->errors(),
        ];
        throw new HttpResponseException(response()->json($response, 400));
    }
}
