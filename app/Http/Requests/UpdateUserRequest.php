<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:10|min:10|unique:users,phone',
            'address' => 'nullable|string',
            'birth' => 'nullable|date_format:Y-m-d',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'type' => [
                'required',
                Rule::in([User::TYPE_ADMIN, User::TYPE_STAFF]),
            ],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name này là bắt buộc phải được điền',
            'name.string' => 'Name này phải là một chuỗi ký tự',
            'name.max' => 'Name này không được vượt quá 255 ký tự.',

            'phone.required' => 'Số điện thoại này là bắt buộc phải được điền',
            'phone.string' => 'Số điện thoại này phải là một chuỗi ký tự',
            'phone.max' => 'Số điện thoại này không được vượt quá 10 ký tự.',
            'phone.min' => 'Số điện thoại này tối thiểu 10 ký tự.',
            'phone.unique'=>'Số điện thoại đã tồn tại vui lòng nhập số khác',

            'address.string' => 'Địa chỉ này phải là một chuỗi ký tự',

            'birth.date_format' => 'Giá trị của trường này phải là một ngày tháng năm và ở định dạng "Y-m-d" (ví dụ: "2023-08-15")',

            'image.image' => 'Ảnh này phải là một tệp hình ảnh (ảnh).',
            'image.max' => ' Kích thước tệp hình ảnh không được vượt quá 2MB..',

            'description.string' => 'Ghi chú của trường này phải là một chuỗi ký tự',

            'email.required' => ' Email này là bắt buộc phải được điền.',
            'email.email' => '  Email của trường này phải là một địa chỉ email hợp lệ..',
            'email.unique'=> 'Email này phải là duy nhất trong bảng "users" (tức là không được trùng với email của người dùng khác',

            'type' => ' Type',
        ];
    }
}
