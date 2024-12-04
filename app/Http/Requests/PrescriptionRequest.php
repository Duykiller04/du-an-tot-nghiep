<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'cutDosePrescription' => 'nullable|exists:cut_dose_prescriptions,id',
            'type_sell' => 'required|string|max:255',
            'sale_date' => 'required|date',

            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|integer|exists:medicines,id',
            'medicines.*.unit_id' => 'required|integer|exists:units,id',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.dosage' => 'required|string|max:255',
            'medicines.*.current_price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Tên khách hàng là bắt buộc.',
            'age.required' => 'Tuổi là bắt buộc.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'type_sell.required' => 'Kiểu bán là bắt buộc.',
            'sale_date.required' => 'Ngày bán là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'weight.min' => 'Cân nặng phải lớn hơn hoặc bằng 0.',
            'age.min' => 'Tuổi phải lớn hơn hoặc bằng 1.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'cutDosePrescription.exists' => 'Đơn thuốc mẫu không tồn tại.',

            'medicines.required' => 'Danh sách thuốc là bắt buộc.',
            'medicines.array' => 'Danh sách thuốc phải là một mảng.',
            'medicines.*.medicine_id.required' => 'Thuốc là bắt buộc.',
            'medicines.*.medicine_id.integer' => 'Thuốc phải là một số nguyên.',
            'medicines.*.medicine_id.exists' => 'Thuốc không tồn tại.',
            'medicines.*.unit_id.required' => 'Đơn vị là bắt buộc.',
            'medicines.*.unit_id.integer' => 'Đơn vị phải là một số nguyên.',
            'medicines.*.unit_id.exists' => 'Đơn vị không tồn tại.',
            'medicines.*.quantity.required' => 'Số lượng là bắt buộc.',
            'medicines.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'medicines.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'medicines.*.dosage.required' => 'Liều lượng là bắt buộc.',
            'medicines.*.dosage.string' => 'Liều lượng phải là một chuỗi.',
            'medicines.*.dosage.max' => 'Liều lượng không được vượt quá 255 ký tự.',
            'medicines.*.current_price.required' => 'Vui lòng nhập thành tiền.',
            'medicines.*.current_price.numeric' => 'Thành tiền phải là một số.',
            'medicines.*.current_price.min' => 'Thành tiền không được nhỏ hơn 0.',
        ];
    }
}
