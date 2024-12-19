<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:255|regex:/^[A-Za-z](.*[\S].*){9,}$/',
            
            'phone' => [
                'required',
                'regex:/^(0(2\d{8,9}|3\d{8}|5\d{8}|7\d{8}|8\d{8}|9\d{8}))$/',
                'numeric',
                Rule::unique('users', 'phone')->whereNull('deleted_at'),
            ],
    
            'email' => [
                'required',
                'email',
                'regex:/^[a-z][a-z0-9._%+-]*@[a-z0-9.-]+\.[a-z]{2,}$/',
                'min:5',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
    
            'address'      => 'nullable|string|min:5|max:255|regex:/\S+/',
            'birth'        => 'nullable|date_format:Y-m-d',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description'  => 'nullable|string',
            'password' => 'string|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&#]/|confirmed',
            'type'         => [
                'required',
                Rule::in([User::TYPE_ADMIN, User::TYPE_STAFF]),
            ],
        ];
    }   
    public function messages(): array
    {
        return [

            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'name.regex' => 'Tên phải bắt đầu bằng chữ cái, có ít nhất 10 ký tự và không chứa ký tự đặc biệt.',
            'name.unique' => 'Tên đã tồn tại. Vui lòng chọn tên khác.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập số bắt đầu bằng 0 và có 10 chữ số. định dạng Sô điện thoại VN',
            'phone.numeric' => 'Số điện thoại phải là một chuỗi số hợp lệ.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',

            'address.min' => 'Địa chỉ phải có ít nhất 5 ký tự.',
            'address.string' => 'địa chỉ phải là chuỗi ký tự hợp lệ.',
            'address.max' => 'địa chỉ không được vượt quá 255 ký tự.',
            'address.regex' => 'Không được nhập khoảng trắng.',

            'birth.date_format' => 'Ngày sinh này phải là một ngày tháng năm và ở định dạng "Y-m-d" (ví dụ: "2023-08-15")',

            'image.image' => 'Ảnh này phải là một tệp hình ảnh (ảnh).',
            'image.mimes' => 'Chỉ chấp nhận định dạng: jpeg, png, jpg, gif, webp.',
            'image.max' => ' Kích thước tệp hình ảnh không được vượt quá 2MB..',

            'description.string' => 'Ghi chú của trường này phải là một chuỗi ký tự',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.min' => 'Email phải có ít nhất 5 ký tự.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.regex' => 'Email phải bắt đầu bằng chữ cái, không chứa ký tự viết hoa và tuân theo định dạng hợp lệ (ví dụ: example@gmail.com).',
            'email.unique' => 'Email đã tồn tại. Vui lòng sử dụng một email khác.',


            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải đáp ứng các yêu cầu sau: 
            - Ít nhất một chữ cái viết hoa (A-Z). 
            - Ít nhất một chữ cái viết thường (a-z). 
            - Ít nhất một chữ số (0-9). 
            - Ít nhất một ký tự đặc biệt (@, $, !, %, *, ?, &, #).',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',

            'type' => ' Type',
        ];
    }
}
