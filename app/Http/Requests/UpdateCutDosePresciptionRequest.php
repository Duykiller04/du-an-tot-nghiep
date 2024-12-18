<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCutDosePresciptionRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'disease_id' => 'exists:diseases,id|required',
            'name_doctor' => 'required|string|max:255',

            'medicines' => 'array',
            'medicines.*' => 'array|required_array_keys:medicine_id,quantity,dosage',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.dosage' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên đơn thuốc không được để trống.',
            'name.string' => 'Tên đơn thuốc phải là một chuỗi ký tự.',
            'name.max' => 'Tên  đơn thuốc không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả đơn thuốc phải là một chuỗi ký tự.',
            'description.max' => 'Mô tả đơn thuốc không được vượt quá 255 ký tự.',

            'name_doctor.required' => 'Tên bác sĩ không được để trống.',
            'name_doctor.string' => 'Tên bác sĩ phải là một chuỗi ký tự.',
            'name_doctor.max' => 'Tên bác sĩ không được vượt quá 255 ký tự.',

            'disease_id.exists' => 'Bệnh không tồn tại trong cơ sở dữ liệu.',
            'disease_id.required' => 'Bệnh không được để trống.',

            'medicines.*.medicine_id.required' => 'Bạn phải chọn một loại thuốc.',
            'medicines.*.medicine_id.exists' => 'Thuốc không tồn tại trong cơ sở dữ liệu.',

            'medicines.*.quantity.required' => 'Số lượng là bắt buộc.',
            'medicines.*.quantity.integer' => 'Số lượng phải là số nguyên.',
         
            'medicines.*.dosage.required' => 'Liều lượng là bắt buộc.',
        ];
    }
}
