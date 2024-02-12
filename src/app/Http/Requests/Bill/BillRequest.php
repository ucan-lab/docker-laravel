<?php

namespace App\Http\Requests\Bill;

use App\Http\Requests\BaseFormRequest;

class BillRequest extends BaseFormRequest
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
            'tables' => 'required|array',
            'tables.*' => 'integer',
            'bill.store_id' => 'required|integer',
            'bill.business_date_id' => 'required|integer',
            // TODO: start_atはフロント別実装に変わった際に修正
            'start_at' => 'required',
            'orders' => 'required|array',
            'orders.*.first_set_id' => 'required|integer',
            'orders.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'tables.required' => parent::UPDATE_SCREEN_MESSAGE,
            'tables.array' => parent::UPDATE_SCREEN_MESSAGE,
            'tables.integer' => parent::UPDATE_SCREEN_MESSAGE,
            'bill.store_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'bill.store_id.integer' => parent::UPDATE_SCREEN_MESSAGE,
            'bill.business_date_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'bill.business_date_id.integer' => parent::UPDATE_SCREEN_MESSAGE,
            'start_at.required' => 'ご来店時間は必須です',
            'orders.required' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.array' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.*.first_set_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.*.first_set_id.integer' => parent::UPDATE_SCREEN_MESSAGE,
            'orders.*.quantity' => '数量は必須です',
            'orders.*.quantity.integer' => '数量は整数で指定してください',
            'orders.*.quantity.min' => '数量は:min以上で指定してください',
        ];
    }

}
