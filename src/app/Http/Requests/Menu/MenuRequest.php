<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends BaseFormRequest
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
            'menu.menu_category_id' => 'required|exists:menu_categories,id',
            'menu.name' => 'required|string|max:20',
            'menu.price' => 'required|integer',
            'menu.insentive_persentage' => [
                'nullable',
                'integer',
                // バック率・バック金額の両方が入力されていたらバリデーションエラー
                function ($attribute, $value, $fail) {
                    $persentage = request()->input('menu.insentive_persentage');
                    $amount = request()->input('menu.insentive_amount');

                    $res = ($persentage !== null && $amount !== null);

                    if ($res) {
                        $fail('バック率・バック金額はどちらか一方を入力してください。');
                    }
                },
            ],
            'menu.insentive_amount' => [
                'nullable',
                'integer',
                // バック率・バック金額の両方が入力されていたらバリデーションエラー
                function ($attribute, $value, $fail) {
                    $persentage = request()->input('menu.insentive_persentage');
                    $amount = request()->input('menu.insentive_amount');

                    $res = ($persentage !== null && $amount !== null);

                    if ($res) {
                        $fail('バック率・バック金額はどちらか一方を入力してください。');
                    }
                },
            ],
            'menu.code' => 'nullable|string|max:20',
            'menu.display' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'menu.menu_category_id.required'=> parent::UPDATE_SCREEN_MESSAGE,
            'menu.menu_category_id.exists'=> parent::UPDATE_SCREEN_MESSAGE,
            'menu.name.required'=> '名称は必須項目です。',
            'menu.name.max'=> '名称は20文字以内で入力してください。',
            'menu.price.required'=> '金額は必須項目です。',
            'menu.price.integer'=> '金額は数値で入力してください。',
            'menu.insentive_persentage.required' => 'バック率とバック金額はどちらか一方は必須です。',
            'menu.insentive_amount.required' => 'バック率とバック金額はどちらか一方は必須です。',
            'menu.code.max'=> 'コードは20文字以内で入力してください。',
            'menu.display.required'=> '表示/非表示は必須項目です。',
            'menu.display.boolean'=> parent::UPDATE_SCREEN_MESSAGE,
        ];
    }
}
