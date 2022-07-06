<?php

namespace App\Http\Requests\UserFavorite;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserFavoriteListRequest extends FormRequest
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
            MainContract::USER_ID => 'required'
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
