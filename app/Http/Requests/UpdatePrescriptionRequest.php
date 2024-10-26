<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrescriptionRequest extends FormRequest
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
    public function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'weight' => 'nullable|numeric|min:0',
            'gender' => 'required|in:0,1',
            'type_sell' => 'required|string|max:255',
        ];
    }

    public function messages()
{
    return [
        'customer_name.required' => 'Tên khách hàng là bắt buộc.',
        'customer_name.string' => 'Tên khách hàng phải là một chuỗi.',
        'customer_name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
        
        'age.required' => 'Tuổi là bắt buộc.',
        'age.integer' => 'Tuổi phải là một số nguyên.',
        'age.min' => 'Tuổi phải lớn hơn hoặc bằng 1.',
        'age.max' => 'Tuổi không được vượt quá 120.',
        
        'phone.nullable' => 'Số điện thoại có thể bỏ trống.',
        'phone.string' => 'Số điện thoại phải là một chuỗi.',
        'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
        
        'address.nullable' => 'Địa chỉ có thể bỏ trống.',
        'address.string' => 'Địa chỉ phải là một chuỗi.',
        'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        
        'email.nullable' => 'Email có thể bỏ trống.',
        'email.email' => 'Email không hợp lệ.',
        'email.max' => 'Email không được vượt quá 255 ký tự.',
        
        'weight.nullable' => 'Cân nặng có thể bỏ trống.',
        'weight.numeric' => 'Cân nặng phải là một số.',
        'weight.min' => 'Cân nặng phải lớn hơn hoặc bằng 0.',
        
        'gender.required' => 'Giới tính là bắt buộc.',
        'gender.in' => 'Giới tính không hợp lệ.',
        
        'type_sell.required' => 'Loại bán là bắt buộc.',
        'type_sell.string' => 'Loại bán phải là một chuỗi.',
        'type_sell.max' => 'Loại bán không được vượt quá 255 ký tự.',
    ];
}

}
