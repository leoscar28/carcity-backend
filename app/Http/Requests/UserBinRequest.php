<?php

namespace App\Http\Requests;

use App\Domain\Contracts\MainContract;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserBinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([MainContract::IIN => "string", MainContract::BIN => "string"])] public function rules(): array
    {
        return [
            MainContract::IIN   =>  'required|exists:users,bin',
            MainContract::BIN   =>  'required'
            // 'name' => 'required|min:5|max:255'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            MainContract::IIN.'.required'   =>  'Вы не указали бин пользователя',
            MainContract::IIN.'.exists'   =>  'Пользователя с таким бин/иин не существует',
            MainContract::BIN.'.required'   =>  'Вы не указали бин/иин ЭЦП'
        ];
    }
}
