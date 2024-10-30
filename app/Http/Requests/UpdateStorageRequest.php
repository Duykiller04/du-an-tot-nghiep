<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStorageRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:storages,name,' . $this->route('storage'),
            'location' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên kho bắt buộc phải được điền',
            'name.string' => 'Tên kho phải là một chuỗi ký tự',
            'name.max' => 'Tên kho không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên kho này đã tồn tại',

            'location.required' => 'Địa chỉ bắt buộc phải được điền',
            'location.string' => 'Địa chỉ  phải là một chuỗi ký tự',
            'location.max' => 'Địa chỉ  không được vượt quá 255 ký tự.',
        ];
    }
}
