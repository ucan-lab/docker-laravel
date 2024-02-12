<?php

namespace App\Http\Requests\Menu;

use Illuminate\Validation\Rule;

class SetMenuRequest extends MenuRequest
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
        // Menuテーブルへのバリデーションルール
        $menuRequestRules = parent::rules();

        // SetMenuテーブルへのバリデーションルール
        $setMenuRequestRules = [
            'set_menu.minutes' => 'required|integer',
        ];

        return array_merge($menuRequestRules, $setMenuRequestRules);
    }

    public function messages()
    {
        // Menuテーブルへのバリデーションメッセージ
        $menuRequestMessages = parent::messages();

        // SetMenuテーブルへのバリデーションメッセージ
        $setMenuRequestMessages = [
            'set_menu.minutes.required' => '時間(分)は必須項目です。',
            'set_menu.minutes.integer' => '時間(分)は数値で入力してください。',
        ];

        return array_merge($menuRequestMessages, $setMenuRequestMessages);
    }
}
