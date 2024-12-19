<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportOrderRequest extends FormRequest
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
            'details.*.storage_id' => 'required|exists:storages,id',
            'details.*.supplier_id' => 'required|exists:suppliers,id',
            'note' => 'nullable|string|max:255',

            'details.*.price_import' => 'required|numeric|min:0',
            'details.*.price_sale' => 'nullable|numeric|min:0',
            'details.*.registration_number' => 'nullable|string|max:255',
            'details.*.origin' => 'nullable|string|max:255',
            'details.*.expiration_date' => 'required|date|after:today',
            'details.*.name_medicine' => 'required|string|max:255',
            'details.*.total' => 'required|numeric|min:0',
            'details.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'details.*.storage_id.required' => 'Kho thuốc là bắt buộc.',
            'details.*.storage_id.exists' => 'Kho thuốc không tồn tại.',
            'details.*.supplier_id.required' => 'Nhà cung cấp là bắt buộc.',
            'details.*.supplier_id.exists' => 'Nhà cung cấp không tồn tại.',
            'note.string' => 'Ghi chú phải là chuỗi.',
            'note.max' => 'Ghi chú không được vượt quá 255 ký tự.',

            'details.*.price_import.required' => 'Giá nhập là bắt buộc.',
            'details.*.price_import.numeric' => 'Giá nhập phải là một số.',
            'details.*.price_import.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',
            'details.*.price_sale.numeric' => 'Giá bán phải là một số.',
            'details.*.price_sale.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',
            'details.*.registration_number.max' => 'Số đăng ký không được vượt quá 255 ký tự.',
            'details.*.origin.max' => 'Xuất xứ không được vượt quá 255 ký tự.',
            'details.*.expiration_date.required' => 'Ngày hết hạn là bắt buộc.',
            'details.*.expiration_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'details.*.expiration_date.after' => 'Ngày hết hạn phải sau ngày hôm nay.',
            'details.*.name_medicine.required' => 'Tên thuốc là bắt buộc.',
            'details.*.name_medicine.string' => 'Tên thuốc phải là chuỗi.',
            'details.*.name_medicine.max' => 'Tên thuốc không được vượt quá 255 ký tự.',
            'details.*.total.required' => 'Tổng tiền là bắt buộc.',
            'details.*.total.numeric' => 'Tổng tiền phải là một số.',
            'details.*.total.min' => 'Tổng tiền phải lớn hơn hoặc bằng 0.',
            'details.*.quantity.required' => 'Số lượng là bắt buộc.',
            'details.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'details.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
        ];
    }
}
