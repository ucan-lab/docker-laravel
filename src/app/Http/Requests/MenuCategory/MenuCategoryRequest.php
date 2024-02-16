<?php

namespace App\Http\Requests\MenuCategory;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class MenuCategoryRequest extends BaseFormRequest
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
            'menu_category.store_id' => 'required|integer',
            'menu_category.sys_menu_category_id' => 'required|integer',
            'menu_category.name' => 'required|string|max:255',
            'menu_category.code' => 'nullable|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json([
            'status' => 'failure',
            'errors' => $errors
        ], 400));
    }

    public function messages()
    {
        return [
            'menu_category.store_id.required'=> parent::UPDATE_SCREEN_MESSAGE,
            'menu_category.store_id.integer'=> parent::UPDATE_SCREEN_MESSAGE,
            'menu_category.sys_menu_category_id.required'=> parent::UPDATE_SCREEN_MESSAGE,
            'menu_category.sys_menu_category_id.integer'=> parent::UPDATE_SCREEN_MESSAGE,
            'menu_category.name.required'=> '名称必須項目です。',
            'menu_category.name.max'=> '名称は255文字以内で入力してください。',
            'menu_category.code.max'=> 'コードは255文字以内で入力してください。',
        ];
    }
}
