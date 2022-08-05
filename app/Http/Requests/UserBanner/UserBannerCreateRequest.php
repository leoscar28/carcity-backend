<?php

namespace App\Http\Requests\UserBanner;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserBannerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            MainContract::USER_ID  =>  'required',
            MainContract::TYPE =>  'required',
            MainContract::TITLE =>  'required',
            MainContract::ROOM_ID   =>  'required',
            MainContract::DESCRIPTION =>  'required',
            MainContract::CATEGORY_ID =>  'required',
            MainContract::BRAND_ID =>  'nullable',
            MainContract::TIME =>  'required',
            MainContract::WEEKDAYS =>  'required',
            MainContract::EMPLOYEE_NAME =>  'required',
            MainContract::EMPLOYEE_PHONE =>  'required',
            MainContract::EMPLOYEE_NAME_ADDITIONAL =>  'nullable',
            MainContract::EMPLOYEE_PHONE_ADDITIONAL =>  'nullable',
            MainContract::IMAGES.'.*' => 'required|image|mimes:jpg,jpeg,png,bmp'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function check(): array
    {
        return $this->validator->validated();
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
