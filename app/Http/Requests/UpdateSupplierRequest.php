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
        $id = $this->input('supplier_id');
        return [
         'tax_code_edit' => [
            'required',
            'max:13',
            Rule::unique('suppliers', 'tax_code')->ignore($id)->whereNull('deleted_at')
        ],
            'name_edit' => 'required|max:100',
            'phone_edit' => [
                'required',
                'regex:/^(0(2\d{8,9}|3\d{8}|5\d{8}|7\d{8}|8\d{8}|9\d{8}))$/',
                'numeric',
                Rule::unique('suppliers', 'phone')->ignore($id)->whereNull('deleted_at'),
            ],
            'address_edit' => "required|max:255",
            'email_edit' => [
                'required',
                'email',
                'regex:/^[a-z][a-z0-9._%+-]*@[a-z0-9.-]+\.[a-z]{2,}$/',
                'min:5',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($id)->whereNull('deleted_at'),
            ],
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
