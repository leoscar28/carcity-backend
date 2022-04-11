<?php

namespace App\Http\Requests\User;

use App\Domain\Contracts\MainContract;
use Illuminate\Foundation\Http\FormRequest;

class UserCrudCreateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            MainContract::ALIAS =>  'nullable|unique:users,login',
            MainContract::ROLE_ID   =>  'required',
            MainContract::NAME  =>  'required',
            MainContract::SURNAME   =>  'required',
            MainContract::PASSWORD  =>  'required',
            MainContract::COMPANY   =>  'required',
            MainContract::BIN   =>  'required|unique:users,bin',
            MainContract::EMAIL =>  'nullable|unique:users,email',
            MainContract::PHONE =>  'required|unique:users,phone',
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
    public function messages(): array
    {
        return [
            MainContract::ALIAS.'.unique'   =>  'Этот логин уже занят',
            MainContract::ROLE_ID.'.required'   =>  'Вы не указали роль',
            MainContract::NAME.'.required'  =>  'Вы не указали имя',
            MainContract::SURNAME.'.required'   =>  'Вы не указали фамилию',
            MainContract::COMPANY.'.required'   =>  'Вы не указали Компанию',
            MainContract::EMAIL.'.unique'   =>  'Этот email уже занят',
            MainContract::PHONE.'.required' =>  'Вы не указали номер телефона',
            MainContract::PHONE.'.unique'   =>  'Этот номер уже занят',
            MainContract::PASSWORD.'.required'  =>  'Вы не укзали пароль',
            MainContract::BIN.'.required'   =>  'Вы не указали БИН/ИИН',
            MainContract::BIN.'.unique' =>  'Этот БИН/ИИН уже занят',
        ];
    }
}
