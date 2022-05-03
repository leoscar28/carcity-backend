<?php

namespace App\Http\Requests\ApplicationSignature;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class ApplicationSignatureMultipleCreateRequest extends FormRequest
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
    #[ArrayShape([MainContract::RID => "string", MainContract::USER_ID => "string", MainContract::SIGNATURE => "string", MainContract::RES => "string"])] public function rules():array
    {
        return [
            MainContract::RID   =>  'required',
            MainContract::USER_ID   =>  'required|exists:users,id',
            MainContract::SIGNATURE =>  'required',
            MainContract::RES   =>  'required',
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
