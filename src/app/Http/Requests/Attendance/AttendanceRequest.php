<?php

namespace App\Http\Requests\Attendance;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class AttendanceRequest extends BaseFormRequest
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
            'store_id' => 'required|numeric',
            'business_date_id' => 'required|numeric',
            'attendances.*.user_id' => 'required|numeric',
            'attendances.*.working_start_at_hh' => 'nullable|numeric',
            'attendances.*.working_start_at_mm' => 'nullable|numeric',
            'attendances.*.working_end_at_hh' => 'nullable|numeric',
            'attendances.*.working_end_at_mm' => 'nullable|numeric',
            'attendances.*.break_total_minute' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'store_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'store_id.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'business_date_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'business_date_id.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.user_id.required' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.user_id.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.working_start_at_hh.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.working_start_at_mm.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.working_end_at_hh.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.working_end_at_mm.numeric' => parent::UPDATE_SCREEN_MESSAGE,
            'attendances.*.break_total_minute.numeric' => parent::UPDATE_SCREEN_MESSAGE,
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
}
