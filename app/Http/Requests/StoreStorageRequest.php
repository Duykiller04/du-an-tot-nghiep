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
            'nameCreate' => 'required|string|min:3|max:255|unique:storages,name,' . $this->route('storage'),
            'locationCreate' => 'required|string|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nameCreate.required' => 'Tên kho bắt buộc phải được điền',
            'nameCreate.string' => 'Tên kho phải là một chuỗi ký tự',
            'nameCreate.min' => 'Tên kho  tối thiếu 3 ký tự.',
            'nameCreate.max' => 'Tên kho không được vượt quá 255 ký tự.',
            'nameCreate.unique' => 'Tên kho này đã tồn tại',

            'locationCreate.required' => 'Địa chỉ bắt buộc phải được điền',
            'locationCreate.min' => 'Địa chỉ kho  tối thiếu 3 ký tự.',
            'locationCreate.string' => 'Địa chỉ phải là một chuỗi ký tự',
            'locationCreate.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ];
    }
}
