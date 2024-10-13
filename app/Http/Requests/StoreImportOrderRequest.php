<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImportOrderRequest extends FormRequest
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
            'price_paid' => 'required|numeric|min:0|max:999999999999',
            'still_in_debt' => 'numeric|min:0|max:999999999999',
            'date_added' => 'required|date',
            'note' => 'nullable|string|max:255',
            'status' => 'required',

            // Chi tiết thuốc
            'details.*.name' => 'required|string',
            'details.*.medicine_code' => 'required|string|max:20',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.price_import' => 'required|numeric|min:0|max:999999999999',
            'details.*.price_sale' => 'required|numeric|min:0|max:999999999999',
            'details.*.registration_number' => 'required|string|max:30',
            'details.*.origin' => 'required|string|max:50',
            'details.*.packaging_specification' => 'required|string|max:50',
            'details.*.active_ingredient' => 'nullable|string|max:30',
            'details.*.concentration' => 'nullable|string|max:50',
            'details.*.dosage' => 'nullable|string|max:100',
            'details.*.administration_route' => 'nullable|string|max:50',
            'details.*.temperature' => 'numeric|min:-50|max:50',
            'details.*.moisture' => 'numeric|min:0|max:100',
            'details.*.date_added' => 'required|date',
            'details.*.expiration_date' => 'required|date',
            'details.*.image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'price_paid.required' => 'Giá thanh toán là bắt buộc.',
            'price_paid.numeric' => 'Giá thanh toán phải là một số.',
            'price_paid.min' => 'Giá thanh toán phải từ 0 đến 999999999999.',
            'still_in_debt.numeric' => 'Số tiền còn nợ phải là một số.',
            'still_in_debt.min' => 'Số tiền còn nợ phải từ 0 đến 999999999999.',
            'date_added.required' => 'Ngày thêm là bắt buộc.',
            'date_added.date' => 'Ngày thêm phải là một ngày hợp lệ.',
            'note.string' => 'Ghi chú phải là một chuỗi ký tự.',
            'note.max' => 'Ghi chú không được vượt quá 255 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',

            // Chi tiết thuốc
            'details.*.name.required' => 'Tên thuốc là bắt buộc.',
            'details.*.name.string' => 'Tên thuốc phải là một chuỗi ký tự.',
            'details.*.medicine_code.required' => 'Mã thuốc là bắt buộc.',
            'details.*.medicine_code.string' => 'Mã thuốc phải là một chuỗi ký tự.',
            'details.*.medicine_code.max' => 'Mã thuốc không được vượt quá 20 ký tự.',
            'details.*.quantity.required' => 'Số lượng là bắt buộc.',
            'details.*.quantity.integer' => 'Số lượng phải là một số nguyên.',
            'details.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'details.*.price_import.required' => 'Giá nhập là bắt buộc.',
            'details.*.price_import.numeric' => 'Giá nhập phải là một số.',
            'details.*.price_import.min' => 'Giá nhập phải từ 0 đến 999999999999.',
            'details.*.price_sale.required' => 'Giá bán là bắt buộc.',
            'details.*.price_sale.numeric' => 'Giá bán phải là một số.',
            'details.*.price_sale.min' => 'Giá bán phải từ 0 đến 999999999999.',
            'details.*.registration_number.required' => 'Số đăng ký là bắt buộc.',
            'details.*.registration_number.string' => 'Số đăng ký phải là một chuỗi ký tự.',
            'details.*.registration_number.max' => 'Số đăng ký không được vượt quá 30 ký tự.',
            'details.*.origin.required' => 'Xuất xứ là bắt buộc.',
            'details.*.origin.string' => 'Xuất xứ phải là một chuỗi ký tự.',
            'details.*.origin.max' => 'Xuất xứ không được vượt quá 50 ký tự.',
            'details.*.packaging_specification.required' => 'Quy cách đóng gói là bắt buộc.',
            'details.*.packaging_specification.string' => 'Quy cách đóng gói phải là một chuỗi ký tự.',
            'details.*.packaging_specification.max' => 'Quy cách đóng gói không được vượt quá 50 ký tự.',
            'details.*.active_ingredient.string' => 'Hoạt chất phải là một chuỗi ký tự.',
            'details.*.active_ingredient.max' => 'Hoạt chất không được vượt quá 30 ký tự.',

            'details.*.concentration.string' => 'Hàm lượng phải là một chuỗi ký tự.',
            'details.*.concentration.max' => 'Hàm lượng không được vượt quá 50 ký tự.',

            'details.*.dosage.string' => 'Liều dùng phải là một chuỗi ký tự.',
            'details.*.dosage.max' => 'Liều dùng không được vượt quá 100 ký tự.',

            'details.*.administration_route.string' => 'Đường dùng phải là một chuỗi ký tự.',
            'details.*.administration_route.max' => 'Đường dùng không được vượt quá 50 ký tự.',

            'details.*.expiration_date.required' => 'Ngày hết hạn là bắt buộc.',
            'details.*.expiration_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ.',

            'details.*.date_added.required' => 'Ngày  nhập là bắt buộc.',
            'details.*.date_added.date' => 'Ngày nhập phải là một ngày hợp lệ.',
            'details.*.image.image' => 'Tệp tải lên phải là một ảnh.',
            'details.*.image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'details.*.image.max' => 'Ảnh không được vượt quá 2MB.',
            'details.*.temperature.numeric' => 'Nhiệt độ phải là một số.',
            'details.*.temperature.min' => 'Nhiệt độ phải trong khoảng từ -50 đến 50 độ C.',
            'details.*.temperature.max' => 'Nhiệt độ phải trong khoảng từ -50 đến 50 độ C.',
            'details.*.moisture.numeric' => 'Độ ẩm phải là một số.',
            'details.*.moisture.min' => 'Độ ẩm phải trong khoảng từ 0 đến 100%.',
            'details.*.moisture.max' => 'Độ ẩm phải trong khoảng từ 0 đến 100%.',
        ];
    }
}
