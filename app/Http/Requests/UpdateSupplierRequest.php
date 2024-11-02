<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $id = $this->segment(3);
        return [
         'tax_code_edit' => [
            'required',
            'max:13',
            Rule::unique('suppliers', 'tax_code')->ignore($id),
        ],
            'name_edit' => 'required|max:100',
            'email_edit' => 'required|string|max:255',
            'phone_edit' => "required|max:11|unique:suppliers,phone,$id",
            'address_edit' => "required|max:255|unique:suppliers,email,$id",
        ];
    }
    public function messages()
    {
        return [
            'tax_code_edit.required' => 'Bắt buộc nhập',
            'tax_code_edit.max' => 'Quá số lượng ký tự',
            'tax_code_edit.unique' => 'Mã số thuế đã được sử dụng',
            'name_edit.required' => 'Bắt buộc nhập',
            'name_edit.max' => 'Quá số lượng ký tự',
            'address_edit.required' => 'Bắt buộc nhập',
            'address_edit.string' => 'Bắt buộc phải là chuỗi',
            'address_edit.max' => 'Quá số lượng ký tự',
            'phone_edit.required' => 'Bắt buộc nhập',
            'phone_edit.unique' => 'Số điện thoại đã tồn tại',
            'phone_edit.max' => 'Quá số lượng ký tự',
            'email_edit' => 'Bắt buộc nhập',
            'email_edit.max' => 'Quá số lượng ký tự',
            'email_edit.unique' => 'Email đã tồn tại',

        ];
    }
}
