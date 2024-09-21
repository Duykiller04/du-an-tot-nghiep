<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStorageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường này là bắt buộc phải được điền',
            'name.string' => 'Giá trị của trường này phải là một chuỗi ký tự',
            'name.max' => 'Giá trị của trường này không được vượt quá 255 ký tự.',

            'location.required' => 'Trường này là bắt buộc phải được điền',
            'location.string' => 'Giá trị của trường này phải là một chuỗi ký tự',
            'location.max' => 'Giá trị của trường này không được vượt quá 255 ký tự.',
        ];
    }
}
