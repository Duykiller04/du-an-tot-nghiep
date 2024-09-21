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
            'phone' => 'required|string|max:15|min:10',
            'address' => 'required|string',
            'birth' => 'required|date_format:Y-m-d',
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
            'name.required' => 'Trường này là bắt buộc phải được điền',
            'name.string' => 'Giá trị của trường này phải là một chuỗi ký tự',
            'name.max' => 'Giá trị của trường này không được vượt quá 255 ký tự.',

            'phone.required' => 'Trường này là bắt buộc phải được điền',
            'phone.string' => 'Giá trị của trường này phải là một chuỗi ký tự',
            'phone.max' => 'Giá trị của trường này không được vượt quá 15 ký tự.',
            'phone.min' => 'Giá trị của trường này tối thiểu 10 ký tự.',

            'address.required' => 'Trường này là bắt buộc phải được điền',
            'address.string' => 'Giá trị của trường này phải là một chuỗi ký tự',

            'birth.required' => 'Trường này là bắt buộc phải được điền',
            'birth.date_format' => 'Giá trị của trường này phải là một ngày tháng năm và ở định dạng "Y-m-d" (ví dụ: "2023-08-15")',

            'image.image' => 'Giá trị của trường này phải là một tệp hình ảnh (ảnh).',
            'image.max' => ' Kích thước tệp hình ảnh không được vượt quá 2MB..',

            'description.string' => 'Giá trị của trường này phải là một chuỗi ký tự',


            'email.required' => ' Trường này là bắt buộc phải được điền.',
            'email.email' => '  Giá trị của trường này phải là một địa chỉ email hợp lệ..',
            'email.unique' => ' Giá trị của trường này phải là duy nhất trong bảng "users" (tức là không được trùng với email của người dùng khác).',

            'password.required' => 'Trường này là bắt buộc phải được điền.',
            'password.min' => ' Giá trị của trường này phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'password không giống nhau vui lòng nhập lại.',

            'type' => ' Type',
        ];
    }
}
