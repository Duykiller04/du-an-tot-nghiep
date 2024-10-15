<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCutDosePrescriptionRequest extends FormRequest
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
            'disease_id' => 'exists:diseases,id',
            'name_hospital' => 'required|string|max:255',
            'name_doctor' => 'required|string|max:255',
            'age' => 'required|integer',
            'phone_doctor' => ['required', 'regex:/^(\+84|0[3|5|7|8|9])+([0-9]{8})$/'],


            'medicines' => 'array',
            'medicines.*' => 'array|required_array_keys:medicine_id,unit_id,quantity,current_price,dosage',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.unit_id' => 'required|exists:units,id',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.current_price' => 'required|numeric|min:0',
            'medicines.*.dosage' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name_hospital.required' => 'Tên bệnh viện không được để trống.',
            'name_hospital.string' => 'Tên bệnh viện phải là một chuỗi ký tự.',
            'name_hospital.max' => 'Tên bệnh viện không được vượt quá 255 ký tự.',

            'name_doctor.required' => 'Tên bác sĩ không được để trống.',
            'name_doctor.string' => 'Tên bác sĩ phải là một chuỗi ký tự.',
            'name_doctor.max' => 'Tên bác sĩ không được vượt quá 255 ký tự.',

            'age.required' => 'Tuổi không được để trống.',
            'age.integer' => 'Tuổi phải là kiểu số.',

            'phone_doctor.required' => 'Trường số điện thoại là bắt buộc.',
            'phone_doctor.regex' => 'Số điện thoại không đúng định dạng.',

            'disease_id.exists' => 'Bệnh không tồn tại trong cơ sở dữ liệu.',

            'medicines.*.medicine_id.required' => 'Bạn phải chọn một loại thuốc.',
            'medicines.*.medicine_id.exists' => 'Thuốc không tồn tại trong cơ sở dữ liệu.',

            'medicines.*.unit_id.required' => 'Bạn phải chọn một đơn vị.',
            'medicines.*.quantity.required' => 'Số lượng là bắt buộc.',
            'medicines.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'medicines.*.current_price.required' => 'Giá là bắt buộc.',
            'medicines.*.dosage.required' => 'Liều lượng là bắt buộc.',
        ];
    }
}
