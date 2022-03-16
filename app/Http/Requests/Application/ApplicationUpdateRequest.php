<?php

namespace App\Http\Requests\Application;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ApplicationUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            MainContract::UPLOAD_STATUS_ID  =>  'nullable',
            MainContract::DOCUMENT_ALL  =>  'nullable',
            MainContract::DOCUMENT_AVAILABLE    =>  'nullable',
            MainContract::COMMENT   =>  'nullable'
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
