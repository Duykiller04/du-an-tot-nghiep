<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
           'nameCreate' => 'required|string|max:100',
           'parent_idCreate' => 'nullable|integer',
        ];
    }
    public function messages()
    {
        return [
            'nameCreate.required' => 'Trường tên là bắt buộc.',
            'nameCreate.string' => 'Trường tên phải là chuỗi.',
            'nameCreate.max' => 'Trường tên không được vượt quá 255 ký tự.',
            'parent_idCreate.integer' => 'Parent ID phải là một số nguyên.',
        ];
    }
}
