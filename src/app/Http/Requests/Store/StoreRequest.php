<?php

namespace App\Http\Requests\Store;

use App\Http\Requests\BaseFormRequest;
use App\Http\Requests\StoreDetail\StoreDetailRequest;

class StoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $storeRequestRules = [
            'store.group_id' => 'required|integer',

            'store.name' => 'required|string|max:255',
            'store.image_path' => 'nullable|string|max:255',
            'store.address' => 'nullable|string|max:255',
            'store.postal_code' => 'nullable|string|max:255',
            'store.tel_number' => 'nullable|string|max:255',
            'store.opening_time' => 'nullable|date_format:H:i',
            'store.closing_time' => 'nullable|date_format:H:i',
            'store.working_time_unit_id' => 'required|integer',
        ];

        $storeDetailRequest = new StoreDetailRequest();
        $storeDetailRequestRules = $storeDetailRequest->rules();

        return array_merge($storeRequestRules, $storeDetailRequestRules);
    }

    public function messages()
    {
        $storeRequestMessages = [
            'store.group_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'store.group_id.integer' => parent::UPDATE_SCREEN_MESSAGE,

            'store.name.required' => '店舗名は必須項目です。',
            'store.name.max' => '店舗名は255文字以内で入力してください。',
            //  'store.image_path.max' => '店舗画像パスは255文字以内で入力してください。',
            'store.address.max' => '住所は255文字以内で入力してください.',
            'store.postal_code.max' => '郵便番号は255文字以内で入力してください.',
            'store.tel_number.max' => '電話番号は255文字以内で入力してください.',
            'store.opening_time.date_format' => parent::UPDATE_SCREEN_MESSAGE,
            'store.closing_time.date_format' => parent::UPDATE_SCREEN_MESSAGE,
            'store.working_time_unit_id.required' => parent::UPDATE_SCREEN_MESSAGE,
        ];

        $storeDetailRequest = new StoreDetailRequest();
        $storeDetailRequestMessages = $storeDetailRequest->messages();

        return array_merge($storeRequestMessages, $storeDetailRequestMessages);
    }
}
