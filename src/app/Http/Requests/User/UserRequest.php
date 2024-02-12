<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\{
    User
};

// use Illuminate\Validation\Rule;

class UserRequest extends BaseFormRequest
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
            'user.display_name' => 'required|string|max:255',
            'general_user.can_login' => 'required|numeric',
            'user.email' => ['nullable', 'string', 'lowercase', 'max:255', 'email', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'user.password' => ['required_with:user.email', 'nullable', Password::defaults(), 'confirmed'],

            'user.icon_img' => 'nullable|string|max:255',
            'user.real_name' => 'nullable|string|max:255',

            'user.tel_number' => 'nullable|string|max:20',
            'user.birth_day' => 'nullable|date',
            'user.postal_code' => 'nullable|string|max:20',
            'user.address' => 'nullable|string|max:255',
            'user.note' => 'nullable|string|max:512',

            'group_role' => 'required|integer',
            'store_role.*.*' => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'user.display_name.required' => 'ユーザー名は必須項目です。',
            'user.display_name.string' => 'ユーザー名は文字列で入力してください。',
            'user.display_name.max' => 'ユーザー名は:max文字以内で入力してください.',

            'general_user.can_login.required' => parent::UPDATE_SCREEN_MESSAGE,
            'general_user.can_login.boolean' => parent::UPDATE_SCREEN_MESSAGE,

            'user.email.email' => '有効なメールアドレスを入力してください。',
            'user.email.unique' => 'このメールアドレスは既に使用されています。',
            'user.email.max' => 'メールアドレスは:max文字以内で入力してください。',

            'user.password.required_with' => 'メールアドレスが入力されている場合、パスワードは必須です。',
            'user.password.confirmed' => 'パスワードが一致しません。',

            // 'user.icon_img.string' => 'ユーザーアイコンは文字列で入力してください。',
            // 'user.icon_img.max' => 'ユーザーアイコンは:max文字以内で入力してください。',

            'user.real_name.string' => '本名は文字列で入力してください。',
            'user.real_name.max' => '本名は:max文字以内で入力してください。',

            'user.tel_number.string' => '電話番号は文字列で入力してください。',
            'user.tel_number.max' => '電話番号は:max文字以内で入力してください。',

            'user.birth_day.date' => '誕生日は日付形式で入力してください。',

            'user.postal_code.string' => '郵便番号は文字列で入力してください。',
            'user.postal_code.max' => '郵便番号は:max文字以内で入力してください。',

            'user.address.string' => '住所は文字列で入力してください。',
            'user.address.max' => '住所は:max文字以内で入力してください。',

            'user.note.string' => '備考は文字列で入力してください。',
            'user.note.max' => '備考は:max文字以内で入力してください。',

            'group_role.required' => 'グループ役職は必須項目です。',
            'group_role.integer' => parent::UPDATE_SCREEN_MESSAGE,

            'store_role.*.*.integer' => parent::UPDATE_SCREEN_MESSAGE,
        ];
    }

}
