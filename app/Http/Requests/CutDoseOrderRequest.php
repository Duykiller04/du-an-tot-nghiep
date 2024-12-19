<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CutDoseOrderRequest extends FormRequest
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
            'phone' => ['required', 'regex:/^(0(2\d{8,9}|3\d{8}|5\d{8}|7\d{8}|8\d{8}|9\d{8}))$/', 'numeric'],
            'address' => 'required|string|max:255',
            'weight' => 'required|integer|min:0',
            'gender' => 'required|in:0,1',
            'unit_id' => 'required|array',
            'unit_id.*' => 'required|integer|exists:units,id', // Each unit_id must be valid
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1', // Each quantity must be an integer greater than 0
            'batch_total_price' => 'required|array',
            'batch_total_price.*' => 'required|numeric|min:0', // Each batch total price must be numeric and >= 0
            'email' => 'nullable|email|max:255', // Email validation
            'disease_id' => 'nullable|exists:diseases,id', // Disease validation
            'dosage' => 'required|string|max:255',
            'note' => 'nullable|string|max:255', // Note validation (nullable)
            'total_price' => 'required|numeric|min:0', // Total price validation
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
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'weight.required' => 'Cân nặng là bắt buộc.',
            'weight.integer' => 'Cân nặng phải là một số nguyên.',
            'weight.min' => 'Cân nặng phải lớn hơn hoặc bằng 0.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính phải là 0 hoặc 1.',
            'unit_id.required' => 'Đơn vị là bắt buộc.',
            'unit_id.array' => 'Đơn vị phải là một mảng.',
            'unit_id.*.required' => 'Đơn vị là bắt buộc.',
            'unit_id.*.integer' => 'Đơn vị phải là một số nguyên.',
            'unit_id.*.exists' => 'Đơn vị không tồn tại.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.array' => 'Số lượng phải là một mảng.',
            'quantity.*.required' => 'Số lượng là bắt buộc.',
            'quantity.*.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.*.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'batch_total_price.required' => 'Giá trị tổng của lô thuốc là bắt buộc.',
            'batch_total_price.array' => 'Giá trị tổng của lô thuốc phải là một mảng.',
            'batch_total_price.*.required' => 'Giá trị tổng của lô thuốc là bắt buộc.',
            'batch_total_price.*.numeric' => 'Giá trị tổng của lô thuốc phải là một số.',
            'batch_total_price.*.min' => 'Giá trị tổng của lô thuốc không được nhỏ hơn 0.',
            'dosage.required' => 'Liều lượng là bắt buộc.',
            'dosage.string' => 'Liều lượng phải là một chuỗi.',
            'dosage.max' => 'Liều lượng không được vượt quá 255 ký tự.',
            'note.string' => 'Ghi chú phải là một chuỗi.',
            'total_price.required' => 'Tổng giá trị đơn hàng là bắt buộc.',
            'total_price.numeric' => 'Tổng giá trị phải là một số.',
            'total_price.min' => 'Tổng giá trị không được nhỏ hơn 0.',
        ];
    }
}
