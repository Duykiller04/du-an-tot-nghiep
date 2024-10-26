<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCutDoseOrderRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'weight' => 'required|integer|min:0',
            'gender' => 'required|in:0,1', // Giả sử 0 là nam, 1 là nữ
        ];
    }
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Tên khách hàng là bắt buộc.',
            'customer_name.string' => 'Tên khách hàng phải là một chuỗi.',
            'customer_name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
            'age.required' => 'Tuổi là bắt buộc.',
            'age.integer' => 'Tuổi phải là một số nguyên.',
            'age.min' => 'Tuổi phải lớn hơn hoặc bằng 0.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.string' => 'Số điện thoại phải là một chuỗi.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'weight.required' => 'Cân nặng là bắt buộc.',
            'weight.integer' => 'Cân nặng phải là một số nguyên.',
            'weight.min' => 'Cân nặng phải lớn hơn hoặc bằng 0.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính phải là 0 hoặc 1.',
        ];
    }
}
