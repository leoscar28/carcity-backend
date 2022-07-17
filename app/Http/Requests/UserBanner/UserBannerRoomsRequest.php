<?php

namespace App\Http\Requests\UserBanner;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RoleContract;
use App\Domain\Contracts\UserBannerContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserBannerRoomsRequest extends FormRequest
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
            MainContract::ROLE_ID   =>  'nullable',
            MainContract::USER_ID => 'nullable',
            MainContract::TYPE => 'nullable',
            MainContract::CREATED_AT => 'nullable',
            MainContract::DATA => 'nullable',
            MainContract::CATEGORY_ID => 'nullable',
            MainContract::BRAND_ID => 'nullable',
            MainContract::TERM => 'nullable'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function check(): array
    {
        $data   =   $this->validator->validated();
        $data[MainContract::STATUS] = [UserBannerContract::STATUS_PUBLISHED];

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
