<?php

namespace App\Http\Requests;

use App\Domain\Contracts\MainContract;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RoomRequest extends FormRequest
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
            MainContract::TIER_ID   =>  'required|exists:tiers,id',
            MainContract::ROOM_TYPE_ID   =>  'required|exists:room_types,id',
            MainContract::USER_ID   =>  'nullable|exists:users,id',
            MainContract::TITLE =>  'required',
            MainContract::STATUS    =>  'required'
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
    public function messages(): array
    {
        return [
            MainContract::TIER_ID.'.required'   =>  'Укажите ярус',
            MainContract::ROOM_TYPE_ID.'.required'  =>  'Укажите тип помещения',
            MainContract::USER_ID.'.exists' =>  'Такого Арендатора не существует',
            MainContract::TITLE.'.required' =>  'Укажите название помещения',
            MainContract::STATUS.'.required'    =>  'Укажите статус'
        ];
    }
}
