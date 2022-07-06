<?php

namespace App\Http\Requests\UserRequest;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserRequestCreateRequest extends FormRequest
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
            MainContract::BRAND_ID   =>  'required',
            MainContract::CATEGORY_ID =>  'required',
            MainContract::DESCRIPTION =>  'required',
            MainContract::PHONE =>  'required'
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
