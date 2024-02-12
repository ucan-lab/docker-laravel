<?php

namespace App\Http\Requests\StoreDetail;

use App\Http\Requests\BaseFormRequest;

class StoreDetailRequest extends BaseFormRequest
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
            'store_detail.invoice_registration_number' => 'nullable|string|max:255',

            'store_detail.service_rate' => 'required|integer',
            'store_detail.service_rate_digit_id' => 'required|integer',
            'store_detail.service_rate_rounding_method_id' => 'required|integer',

            'store_detail.consumption_tax_rate' => 'required|integer',
            'store_detail.consumption_tax_rate_digit_id' => 'required|integer',
            'store_detail.consumption_tax_rate_rounding_method_id' => 'required|integer',
            'store_detail.consumption_tax_type_id' => 'required|integer',

            'store_detail.user_incentive_digit_id' => 'required|integer',
            'store_detail.user_incentive_rounding_method_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'store_detail.invoice_registration_number.max' => 'インボイス登録番号は255文字以内で入力してください.',

            'store_detail.service_rate.required' => 'サービス料率は必須項目です.',
            'store_detail.service_rate.integer' => 'サービス料率は整数で入力してください.',
            'store_detail.service_rate_digit_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'store_detail.service_rate_rounding_method_id.required' => parent::UPDATE_SCREEN_MESSAGE,

            'store_detail.consumption_tax_rate.required' => '消費税率は必須項目です.',
            'store_detail.consumption_tax_rate.integer' => '消費税率は整数で入力してください.',
            'store_detail.consumption_tax_rate_digit_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'store_detail.consumption_tax_rate_rounding_method_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'store_detail.consumption_tax_type_id.required' => parent::UPDATE_SCREEN_MESSAGE,

            'store_detail.user_incentive_digit_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'store_detail.user_incentive_rounding_method_id.required' => parent::UPDATE_SCREEN_MESSAGE,
        ];
    }
}
