<?php

namespace App\Http\Requests\ExtensionSet;

use App\Http\Requests\BaseFormRequest;

class ExtensionSetRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bill_id' => 'required|integer',
            'orders.start_at' => 'required',
            'orders.quantity' => 'required|integer|min:1',
            'orders.extension_set_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'bill_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'bill_id.integer' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.start_at.required' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.quantity.required' => '数量は必須です',
            'orders.quantity.integer' => '数量は整数で指定してください',
            'orders.quantity.min' => '数量は:min以上で指定してください',
            'orders.extension_set_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.extension_set_id.integer' => parent::UPDATE_SCREEN_MESSAGE,
        ];
    }

}
