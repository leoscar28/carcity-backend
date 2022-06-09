<?php

namespace App\Http\Requests;

use App\Domain\Contracts\MainContract;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class TierRequest extends FormRequest
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
    #[ArrayShape([MainContract::TITLE => "string", MainContract::STATUS => "string"])] public function rules(): array
    {
        return [
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
            MainContract::TITLE.'.required' =>  'Укажите название яруса'
        ];
    }
}
