<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'medicine.medicine_code' => 'required|string|max:20|unique:medicines,medicine_code',
            'medicine.name' => 'required|string',
            'batch.price_import' => 'required|numeric|between:0,999999999999',
            'batch.price_sale' => 'required|numeric|between:0,999999999999',
            'batch.packaging_specification' => 'required|string|max:50',
            'batch.registration_number' => 'required|string|max:30',
            'medicine.active_ingredient' => 'nullable|string|max:30',
            'medicine.concentration' => 'nullable|string|max:50',
            'medicine.dosage' => 'nullable|string|max:100',
            'medicine.administration_route' => 'nullable|string|max:50',
            'batch.origin' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'medicine.temperature' => 'nullable|numeric|between:-50,50',
            'medicine.moisture' => 'nullable|numeric|between:0,100',

            'so_luong.*' => 'required|integer|min:1',

            'don_vi.*' => 'required|exists:units,id|distinct',

            'supplier_id' => 'required|exists:suppliers,id',

            'medicine.category_id' => 'required|integer|exists:categories,id',
            'storage_id' => 'required|integer|exists:storages,id',

            'batch.expiration_date' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
        ];
    }

    public function messages()
    {
        return [
            'medicine.medicine_code.required' => 'Mã thuốc là bắt buộc.',
            'medicine.medicine_code.string' => 'Mã thuốc phải là một chuỗi ký tự.',
            'medicine.medicine_code.max' => 'Mã thuốc không được vượt quá 20 ký tự.',
            'medicine.medicine_code.unique' => 'Mã thuốc đã tồn tại.',

            'medicine.name.required' => 'Tên thuốc là bắt buộc.',
            'medicine.name.string' => 'Tên thuốc phải là một chuỗi ký tự.',

            'batch.price_import.required' => 'Giá nhập là bắt buộc.',
            'batch.price_import.numeric' => 'Giá nhập phải là một số.',
            'batch.price_import.between' => 'Giá nhập phải từ 0 đến 999999999999.',

            'batch.price_sale.required' => 'Giá bán là bắt buộc.',
            'batch.price_sale.numeric' => 'Giá bán phải là một số.',
            'batch.price_sale.between' => 'Giá bán phải từ 0 đến 999999999999.',

            'batch.packaging_specification.required' => 'Quy cách đóng gói là bắt buộc.',
            'batch.packaging_specification.string' => 'Quy cách đóng gói phải là một chuỗi ký tự.',
            'batch.packaging_specification.max' => 'Quy cách đóng gói không được vượt quá 50 ký tự.',

            'batch.registration_number.required' => 'Số đăng ký là bắt buộc.',
            'batch.registration_number.string' => 'Số đăng ký phải là một chuỗi ký tự.',
            'batch.registration_number.max' => 'Số đăng ký không được vượt quá 30 ký tự.',

            'medicine.active_ingredient.string' => 'Hoạt chất phải là một chuỗi ký tự.',
            'medicine.active_ingredient.max' => 'Hoạt chất không được vượt quá 30 ký tự.',

            'medicine.concentration.string' => 'Hàm lượng phải là một chuỗi ký tự.',
            'medicine.concentration.max' => 'Hàm lượng không được vượt quá 50 ký tự.',

            'medicine.dosage.string' => 'Liều dùng phải là một chuỗi ký tự.',
            'medicine.dosage.max' => 'Liều dùng không được vượt quá 100 ký tự.',

            'medicine.administration_route.string' => 'Đường dùng phải là một chuỗi ký tự.',
            'medicine.administration_route.max' => 'Đường dùng không được vượt quá 50 ký tự.',

            'batch.origin.required' => 'Xuất xứ là bắt buộc.',
            'batch.origin.string' => 'Xuất xứ phải là một chuỗi ký tự.',
            'batch.origin.max' => 'Xuất xứ không được vượt quá 50 ký tự.',

            'image.image' => 'Tệp tải lên phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',

            'so_luong.*.required' => 'Vui lòng nhập số lượng.',
            'so_luong.*.integer' => 'Số lượng phải là số nguyên.',
            'so_luong.*.min' => 'Số lượng phải lớn hơn 0.',
        
            'don_vi.*.required' => 'Vui lòng chọn đơn vị.',
            'don_vi.*.exists' => 'Đơn vị đã chọn không hợp lệ.',
            'don_vi.*.distinct' => 'Các đơn vị không được trùng lặp.',

            'supplier_id.required' => 'Bạn phải chọn ít nhất một nhà cung cấp.',
            'supplier_id.exists' => 'Nhà cung cấp không tồn tại.',

            'medicine.category_id.required' => 'Danh mục thuốc là bắt buộc.',
            'medicine.category_id.integer' => 'Danh mục thuốc phải là một số nguyên.',
            'medicine.category_id.exists' => 'Danh mục thuốc không tồn tại.',

            'storage_id.required' => 'Kho lưu trữ là bắt buộc.',
            'storage_id.integer' => 'Kho lưu trữ phải là một số nguyên.',
            'storage_id.exists' => 'Kho lưu trữ không tồn tại.',

            'medicine.temperature.numeric' => 'Nhiệt độ phải là một số.',
            'medicine.temperature.between' => 'Nhiệt độ phải trong khoảng từ -50 đến 50 độ C.',

            'medicine.moisture.numeric' => 'Độ ẩm phải là một số.',
            'medicine.moisture.between' => 'Độ ẩm phải trong khoảng từ 0 đến 100%.',

            'batch.expiration_date.required' => 'Ngày hết hạn là bắt buộc.',
            'batch.expiration_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',
            'batch.expiration_date.after_or_equal' => 'Ngày hết hạn phải là ngày hôm nay hoặc trong tương lai.',
        ];
    }
}
