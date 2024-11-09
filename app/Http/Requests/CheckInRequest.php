<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
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
            'captured_image' => 'required|string',
            'shift_id' => 'required|integer|exists:shifts,id',
            'reasons' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'captured_image.required' => 'Ảnh check-in là bắt buộc.',
            'captured_image.string' => 'Ảnh check-in phải có định dạng hợp lệ (base64).',
            'shift_id.required' => 'Ca làm việc là bắt buộc.',
            'shift_id.integer' => 'Ca làm việc phải là một số hợp lệ.',
            'shift_id.exists' => 'Ca làm việc không tồn tại.',
            'reasons.string' => 'Lý do phải là một chuỗi văn bản hợp lệ.',
        ];
    }
}
