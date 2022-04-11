<?php

namespace App\Http\Requests\User;

use App\Domain\Contracts\MainContract;
use Illuminate\Foundation\Http\FormRequest;

class UserCrudUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            MainContract::ALIAS =>  'nullable|unique:users,login',
            MainContract::ROLE_ID   =>  'required',
            MainContract::NAME  =>  'required',
            MainContract::SURNAME   =>  'required',
            MainContract::EMAIL =>  'nullable|unique:users,email',
            MainContract::COMPANY   =>  'required',
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
            MainContract::ALIAS.'.unique'   =>  'Этот логин уже занят',
            MainContract::ROLE_ID.'.required'   =>  'Вы не указали роль',
            MainContract::NAME.'.required'  =>  'Вы не указали имя',
            MainContract::SURNAME.'.required'   =>  'Вы не указали фамилию',
            MainContract::COMPANY.'.required'   =>  'Вы не указали Компанию',
            MainContract::EMAIL.'.unique'   =>  'Этот email уже занят',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            MainContract::ALIAS.'.unique'   =>  'Этот логин уже занят',
            MainContract::ROLE_ID.'.required'   =>  'Вы не указали роль',
            MainContract::NAME.'.required'  =>  'Вы не указали имя',
            MainContract::SURNAME.'.required'   =>  'Вы не указали фамилию',
            MainContract::COMPANY.'.required'   =>  'Вы не указали Компанию',
            MainContract::EMAIL.'.unique'   =>  'Этот email уже занят',
        ];
    }
}
