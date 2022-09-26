<?php

namespace App\Http\Requests\FeedbackRequest;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RoleContract;
use App\Domain\Contracts\UserBannerContract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class FeedbackRequestListRequest extends FormRequest
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
            MainContract::STATUS => 'nullable',
            MainContract::CREATED_AT => 'nullable',
            MainContract::DATA => 'nullable',
            MainContract::TITLE => 'nullable',
            MainContract::ID => 'nullable'
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

        if (array_key_exists(MainContract::ID,$data)) {
            $data[MainContract::DATA][] =   [MainContract::ID,$data[MainContract::ID]];
        }

        if (array_key_exists(MainContract::USER_ID,$data)) {
            $data[MainContract::DATA][] =   [MainContract::USER_ID,$data[MainContract::USER_ID]];
        }

        if (array_key_exists(MainContract::STATUS,$data)) {
            $data[MainContract::DATA][] =   [MainContract::STATUS,$data[MainContract::STATUS]];
        }

        if (array_key_exists(MainContract::CREATED_AT,$data)) {
            $date   =   explode('_',$data[MainContract::CREATED_AT]);
            $data[MainContract::CREATED_AT] =   [date('Y-m-d',strtotime($date[0])).' 00:00:00',date('Y-m-d',strtotime($date[1])).' 23:59:59'];
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
