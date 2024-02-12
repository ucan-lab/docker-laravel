<?php

namespace App\Http\Requests\PaymentMethod;

use App\Http\Requests\BaseFormRequest;

class PaymentMethodRequest extends BaseFormRequest
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
            'payment_method.store_id' => 'required|numeric',
            'payment_method.sys_payment_method_category_id' => 'required|numeric',
            'payment_method.name' => 'required|string|max:25',
            'payment_method.code' => 'nullable|string|max:25',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.store_id.required' =>parent::UPDATE_SCREEN_MESSAGE,
            'payment_method.store_id.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'payment_method.sys_payment_method_category_id.required' => '支払い方法カテゴリは必須です。',
            'payment_method.sys_payment_method_category_id.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'payment_method.name.required' => '名称は必須です。',
            'payment_method.name.max' => '名称は:max文字以下で指定してください。',
            'payment_method.code.max' => 'コードは:max文字以下で指定してください。',
        ];
    }
}
