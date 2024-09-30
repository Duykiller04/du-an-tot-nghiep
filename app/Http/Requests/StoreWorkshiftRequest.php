<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkshiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Thay đổi nếu bạn cần kiểm tra quyền truy cập
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id', // Kiểm tra user_id phải tồn tại trong bảng users
            'name' => 'required|string|max:255',
            'target' => 'required|integer|min:0', // Giả sử target là số nguyên và không âm
            'is_applied' => 'boolean', // is_applied là một checkbox, nên là kiểu boolean
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ];
    }
}
