<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'address' => 'nullable|string|max:255',
            'birth' => 'nullable|date_format:Y-m-d',
            'image' => 'image|max:2048',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'type' => ['required', 'in:' . User::TYPE_ADMIN . ',' . User::TYPE_STAFF],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên người dùng này là bắt buộc phải được điền',
            'name.string' => 'Giá trị của trường này phải là một chuỗi ký tự',
            'name.max' => 'Giá trị của trường này không được vượt quá 255 ký tự.',

            'phone.required' => 'Số này bắt buộc phải được điền',
            'phone.string' => 'Số này phải là một chuỗi ký tự',
            'phone.max' => 'Số này không được vượt quá 10 ký tự.',
            'phone.min' => 'Số này tối thiểu 10 ký tự.',
            'phone.unique' => 'Số điện thoại đã tồn tại vui lòng nhập số khác',

            'address.string' => 'địa chỉ phải là chuỗi ký tự hợp lệ.',
            'address.max' => 'địa chỉ không được vượt quá 255 ký tự.',

            'birth.date_format' => 'Ngày sinh này phải là một ngày tháng năm và ở định dạng "Y-m-d" (ví dụ: "2023-08-15")',

            'image.image' => 'Ảnh này phải là một tệp hình ảnh (ảnh).',
            'image.max' => ' Kích thước tệp hình ảnh không được vượt quá 2MB..',

            'description.string' => 'Ghi chú của trường này phải là một chuỗi ký tự',

            'email.required' => 'Email này là bắt buộc phải được điền.',
            'email.email' => 'Email này phải là một địa chỉ email hợp lệ..',
            'email.unique' => 'Email này phải là duy nhất trong bảng "users" (tức là không được trùng với email của người dùng khác).',

            'password.required' => 'Mật khẩu này là bắt buộc phải được điền.',
            'password.min' => ' Mật khẩu của trường này phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu không giống nhau vui lòng nhập lại.',

            'type' => ' Type',
        ];
    }
}
