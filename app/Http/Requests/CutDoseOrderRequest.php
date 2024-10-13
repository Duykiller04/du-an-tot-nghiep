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
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'weight' => 'required|integer|min:0',
            'gender' => 'required|in:0,1', // Giả sử 0 là nam, 1 là nữ
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|integer|exists:medicines,id',
            'medicines.*.unit_id' => 'required|integer|exists:units,id',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.dosage' => 'required|string|max:255',
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
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'weight.required' => 'Cân nặng là bắt buộc.',
            'weight.integer' => 'Cân nặng phải là một số nguyên.',
            'weight.min' => 'Cân nặng phải lớn hơn hoặc bằng 0.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'gender.in' => 'Giới tính phải là 0 hoặc 1.',
            'medicines.required' => 'Danh sách thuốc là bắt buộc.',
            'medicines.array' => 'Danh sách thuốc phải là một mảng.',
            'medicines.*.medicine_id.required' => 'ID thuốc là bắt buộc.',
            'medicines.*.medicine_id.integer' => 'ID thuốc phải là một số nguyên.',
            'medicines.*.medicine_id.exists' => 'ID thuốc không tồn tại.',
            'medicines.*.unit_id.required' => 'ID đơn vị là bắt buộc.',
            'medicines.*.unit_id.integer' => 'ID đơn vị phải là một số nguyên.',
            'medicines.*.unit_id.exists' => 'ID đơn vị không tồn tại.',
            'medicines.*.quantity.required' => 'Số lượng là bắt buộc.',
            'medicines.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'medicines.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'medicines.*.dosage.required' => 'Liều lượng là bắt buộc.',
            'medicines.*.dosage.string' => 'Liều lượng phải là một chuỗi.',
            'medicines.*.dosage.max' => 'Liều lượng không được vượt quá 255 ký tự.',
        ];
    }
}
