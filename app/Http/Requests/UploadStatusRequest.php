<?php

namespace App\Http\Requests;

use App\Domain\Contracts\MainContract;
use Illuminate\Foundation\Http\FormRequest;

class UploadStatusRequest extends FormRequest
{

    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules():array
    {
        return [
            MainContract::TITLE =>  'required',
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }

    public function messages(): array
    {
        return [
            //
        ];
    }
}
