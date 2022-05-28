<?php

namespace App\Http\Requests\User;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserAuthRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'login' =>  'required',
            'password'  =>  'required'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function check(): array
    {
        $data   =   $this->validator->validated();
        if (filter_var($data[MainContract::LOGIN],FILTER_VALIDATE_EMAIL)) {
            $data[MainContract::LOGIN]  =   [
                MainContract::EMAIL =>    $data[MainContract::LOGIN]
            ];
        } elseif (str_starts_with($data[MainContract::LOGIN],'is')) {
            $data[MainContract::LOGIN]  =   [
                MainContract::ALIAS =>  $data[MainContract::LOGIN]
            ];
        } else {
            $data[MainContract::LOGIN]  =   [
                MainContract::PHONE =>    $data[MainContract::LOGIN]
            ];
        }
        $data[MainContract::LOGIN][MainContract::STATUS] =   1;
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
