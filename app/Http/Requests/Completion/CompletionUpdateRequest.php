<?php

namespace App\Http\Requests\Completion;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CompletionUpdateRequest extends FormRequest
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
            MainContract::UPLOAD_STATUS_ID  =>  'nullable',
            MainContract::CUSTOMER  =>  'nullable',
            MainContract::CUSTOMER_ID   =>  'nullable',
            MainContract::NUMBER    =>  'nullable',
            MainContract::ORGANIZATION  =>  'nullable',
            MainContract::DATE  =>  'nullable',
            MainContract::SUM   =>  'nullable',
            MainContract::NAME  =>  'nullable',
            MainContract::STATUS    =>  'nullable'
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
