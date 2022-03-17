<?php

namespace App\Http\Requests\Application;

use App\Domain\Contracts\MainContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ApplicationCreateRequest extends FormRequest
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
            MainContract::DATA  =>  'required',

//            MainContract::CUSTOMER  =>  'nullable',
//            MainContract::CUSTOMER_ID   =>  'nullable',
//            MainContract::NUMBER    =>  'nullable',
//            MainContract::ORGANIZATION  =>  'nullable',
//            MainContract::DATE  =>  'nullable',
//            MainContract::SUM   =>  'nullable',
//            MainContract::NAME  =>  'nullable',
        ];
    }

    /**
     * @throws ValidationException
     */
    public function check(): array
    {
        $data   =   $this->validator->validated();
        if (array_key_exists(MainContract::DATA,$data)) {
            $data   =   json_decode($data[MainContract::DATA],true)[MainContract::DATA];
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
