<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'medicine.medicine_code' => 'required|string|max:20',
            'medicine.name' => 'required|string',
            'medicine.active_ingredient' => 'nullable|string|max:30',
            'medicine.concentration' => 'nullable|string|max:50',
            'medicine.dosage' => 'nullable|string|max:100',
            'medicine.administration_route' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'medicine.temperature' => 'nullable|numeric|between:-50,50',
            'medicine.moisture' => 'nullable|numeric|between:0,100',
            'medicine.category_id' => 'required|integer|exists:categories,id',
            'batches.*.price_in_smallest_unit' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }

    public function messages()
    {
        return [
            'medicine.medicine_code.required' => 'Mã thuốc là bắt buộc.',
            'medicine.medicine_code.string' => 'Mã thuốc phải là một chuỗi ký tự.',
            'medicine.medicine_code.max' => 'Mã thuốc không được vượt quá 20 ký tự.',

            'medicine.name.required' => 'Tên thuốc là bắt buộc.',
            'medicine.name.string' => 'Tên thuốc phải là một chuỗi ký tự.',

            'medicine.active_ingredient.string' => 'Hoạt chất phải là một chuỗi ký tự.',
            'medicine.active_ingredient.max' => 'Hoạt chất không được vượt quá 30 ký tự.',

            'medicine.concentration.string' => 'Hàm lượng phải là một chuỗi ký tự.',
            'medicine.concentration.max' => 'Hàm lượng không được vượt quá 50 ký tự.',

            'medicine.dosage.string' => 'Liều dùng phải là một chuỗi ký tự.',
            'medicine.dosage.max' => 'Liều dùng không được vượt quá 100 ký tự.',

            'medicine.administration_route.string' => 'Đường dùng phải là một chuỗi ký tự.',
            'medicine.administration_route.max' => 'Đường dùng không được vượt quá 50 ký tự.',

            'image.image' => 'Tệp tải lên phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',

            'medicine.category_id.required' => 'Danh mục thuốc là bắt buộc.',
            'medicine.category_id.integer' => 'Danh mục thuốc phải là một số nguyên.',
            'medicine.category_id.exists' => 'Danh mục thuốc không tồn tại.',

            'medicine.temperature.numeric' => 'Nhiệt độ phải là một số.',
            'medicine.temperature.between' => 'Nhiệt độ phải trong khoảng từ -50 đến 50 độ C.',

            'medicine.moisture.numeric' => 'Độ ẩm phải là một số.',
            'medicine.moisture.between' => 'Độ ẩm phải trong khoảng từ 0 đến 100%.',

            'batches.*.price_in_smallest_unit.required' => 'Giá là bắt buộc.',
            'batches.*.price_in_smallest_unit.numeric' => 'Giá phải là số.',
            'batches.*.price_in_smallest_unit.min' => 'Giá không được nhỏ hơn 0.',
            'batches.*.price_in_smallest_unit.regex' => 'Giá chỉ được chứa tối đa 2 chữ số sau dấu thập phân.',
        ];
    }
}
