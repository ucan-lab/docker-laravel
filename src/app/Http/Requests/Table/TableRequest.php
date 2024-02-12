<?php

namespace App\Http\Requests\Table;

use App\Http\Requests\BaseFormRequest;

class TableRequest extends BaseFormRequest
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
            'table.store_id' => 'required|numeric',
            'table.name' => 'required|string|max:25|',
            'table.display' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'table.store_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'table.store_id.numeric' => parent::UPDATE_SCREEN_MESSAGE,

            'table.name.required' => 'テーブル名は必須項目です。',
            'table.name.string' => 'テーブル名は文字列で入力してください。',
            'table.name.max' => 'テーブル名は:max文字以内で入力してください.',

            'table.display.required' => '表示/非表示は必須です。',
            'table.display.boolean' => parent::UPDATE_SCREEN_MESSAGE,
        ];
    }

}
