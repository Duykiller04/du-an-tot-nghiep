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
            'storage_id' => 'required|exists:storages,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price_paid' => 'required|numeric|min:0',
            'still_in_debt' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',

            'details.*.type_product' => 'required|in:0,1',
            'details.*.name' => 'required|string|max:255',
            'details.*.category_id' => 'required|exists:categories,id',
            'details.*.medicine_code' => 'required|string|max:255',
            'details.*.price_import' => 'required|numeric|min:0',
            'details.*.price_sale' => 'nullable|numeric|min:0',
            'details.*.registration_number' => 'nullable|string|max:255',
            'details.*.origin' => 'nullable|string|max:255',
            'details.*.packaging_specification' => 'nullable|string|max:255',
            'details.*.temperature' => 'nullable|numeric',
            'details.*.moisture' => 'nullable|numeric',
            'details.*.expiration_date' => 'nullable|date|after:today',
            'details.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'details.*.units.*.quantity' => 'required|integer|min:1',
            'details.*.units.*.unit' => 'required|exists:units,id',
        ];
    }

    public function messages()
    {
        return [
            'storage_id.required' => 'Kho thuốc là bắt buộc.',
            'storage_id.exists' => 'Kho thuốc không tồn tại.',
            'supplier_id.required' => 'Nhà cung cấp là bắt buộc.',
            'supplier_id.exists' => 'Nhà cung cấp không tồn tại.',
            'price_paid.required' => 'Số tiền đã trả là bắt buộc.',
            'price_paid.numeric' => 'Số tiền đã trả phải là một số.',
            'price_paid.min' => 'Số tiền đã trả không được âm.',
            'still_in_debt.required' => 'Còn nợ là bắt buộc.',
            'still_in_debt.numeric' => 'Còn nợ phải là một số.',
            'still_in_debt.min' => 'Còn nợ không được âm.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.string' => 'Trạng thái phải là chuỗi.',
            'status.max' => 'Trạng thái không được vượt quá 255 ký tự.',
            'note.string' => 'Ghi chú phải là chuỗi.',
            'note.max' => 'Ghi chú không được vượt quá 255 ký tự.',

            'details.*.type_product.required' => 'Loại sản phẩm là bắt buộc.',
            'details.*.type_product.in' => 'Loại sản phẩm không hợp lệ.',
            'details.*.name.required' => 'Tên thuốc là bắt buộc.',
            'details.*.name.string' => 'Tên thuốc phải là một chuỗi.',
            'details.*.name.max' => 'Tên thuốc không được vượt quá 255 ký tự.',
            'details.*.category_id.required' => 'Danh mục thuốc là bắt buộc.',
            'details.*.category_id.exists' => 'Danh mục thuốc không tồn tại.',
            'details.*.medicine_code.required' => 'Mã thuốc là bắt buộc.',
            'details.*.medicine_code.max' => 'Mã thuốc không được vượt quá 255 ký tự.',
            'details.*.price_import.required' => 'Giá nhập là bắt buộc.',
            'details.*.price_import.numeric' => 'Giá nhập phải là một số.',
            'details.*.price_import.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',
            'details.*.price_sale.numeric' => 'Giá bán phải là một số.',
            'details.*.registration_number.max' => 'Số đăng ký không được vượt quá 255 ký tự.',
            'details.*.origin.max' => 'Xuất xứ không được vượt quá 255 ký tự.',
            'details.*.packaging_specification.max' => 'Quy cách đóng gói không được vượt quá 255 ký tự.',
            'details.*.temperature.numeric' => 'Nhiệt độ bảo quản phải là một số.',
            'details.*.moisture.numeric' => 'Độ ẩm bảo quản phải là một số.',
            'details.*.expiration_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'details.*.expiration_date.after' => 'Ngày hết hạn phải sau ngày hôm nay.',
            'details.*.image.image' => 'Hình ảnh không hợp lệ.',
            'details.*.image.mimes' => 'Hình ảnh phải có định dạng: :jpeg,png,jpg,gif.',
            'details.*.units.*.quantity.required' => 'Số lượng là bắt buộc.',
            'details.*.units.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'details.*.units.*.quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'details.*.units.*.unit.required' => 'Đơn vị là bắt buộc.',
            'details.*.units.*.unit.exists' => 'Đơn vị không tồn tại.',
        ];
    }
}
