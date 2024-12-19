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
            'customer_name_tt' => 'required|string|max:255',
            'dosage_tt' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'total_price' => 'required|numeric|min:0',
    
            'unit_id' => 'required|array',
            'unit_id.*' => 'required|integer|exists:units,id',
    
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
    
            'batch_total_price' => 'required|array',
            'batch_total_price.*' => 'required|numeric|min:0',
            
            'cutDosePrescription' => 'nullable|exists:cut_dose_prescriptions,id',
        ];
    }

    public function messages()
    {
        return [
            'customer_name_tt.required' => 'Tên khách hàng là bắt buộc.',
            'dosage_tt.required' => 'Liều lượng là bắt buộc.',
            'total_price.required' => 'Tổng tiền là bắt buộc.',
            'total_price.numeric' => 'Tổng tiền phải là một số.',
            'total_price.min' => 'Tổng tiền không được nhỏ hơn 0.',
            
            'unit_id.required' => 'Danh sách đơn vị là bắt buộc.',
            'unit_id.array' => 'Danh sách đơn vị phải là một mảng.',
            'unit_id.*.required' => 'Đơn vị là bắt buộc.',
            'unit_id.*.integer' => 'Đơn vị phải là một số nguyên.',
            'unit_id.*.exists' => 'Đơn vị không tồn tại.',
    
            'quantity.required' => 'Danh sách số lượng là bắt buộc.',
            'quantity.array' => 'Danh sách số lượng phải là một mảng.',
            'quantity.*.required' => 'Số lượng là bắt buộc.',
            'quantity.*.integer' => 'Số lượng phải là một số nguyên.',
            'quantity.*.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            
            'batch_total_price.required' => 'Danh sách giá tổng lô thuốc là bắt buộc.',
            'batch_total_price.array' => 'Danh sách giá tổng lô thuốc phải là một mảng.',
            'batch_total_price.*.required' => 'Giá tổng lô thuốc là bắt buộc.',
            'batch_total_price.*.numeric' => 'Giá tổng lô thuốc phải là một số.',
            'batch_total_price.*.min' => 'Giá tổng lô thuốc không được nhỏ hơn 0.',
            
            'cutDosePrescription.exists' => 'Đơn thuốc mẫu không tồn tại.',
        ];
    }
}
