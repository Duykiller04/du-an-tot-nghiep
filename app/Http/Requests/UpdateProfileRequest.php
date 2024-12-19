<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
         $id = $this->route('id');
         return [
             'name' => 'required|string|max:255|regex:/^[A-Za-z](.*[\S].*){9,}$/',
             'phone' => [
                 'required',
                 'regex:/^(0(2\d{8,9}|3\d{8}|5\d{8}|7\d{8}|8\d{8}|9\d{8}))$/',
                 'numeric',
                 Rule::unique('users', 'phone')->whereNull('deleted_at')->ignore($id),   
             ],
            'email' => [
             'required',
             'email',
             'regex:/^[a-z][a-z0-9._%+-]*@[a-z0-9.-]+\.[a-z]{2,}$/',
             'min:5',
             'max:255',
             Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($id, 'id'),
             ],
 
 
             'address'      => 'nullable|string|min:5|max:255|regex:/\S+/',
             'birth'        => 'nullable|date_format:Y-m-d',
             'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
             'description'  => 'nullable|string',
             'new_password' => 'nullable|string|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&#]/|',
         ];
     }
 
     public function messages()
     {
         return [
             'name.required' => 'Vui lòng nhập tên.',
             'name.string' => 'Tên phải là chuỗi ký tự hợp lệ.',
             'name.max' => 'Tên không được dài hơn 255 ký tự.',
             'name.regex' => 'Tên phải bắt đầu bằng chữ cái và có tối thiểu 10 ký tự.',
             'name.unique' => 'Tên đã tồn tại, vui lòng chọn tên khác.',
 
             'phone.required' => 'Số điện thoại là bắt buộc.',
             'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập số bắt đầu bằng 0 và có 10 chữ số. định dạng Sô điện thoại VN',
             'phone.numeric' => 'Số điện thoại phải là một chuỗi số hợp lệ.',
             'phone.unique' => 'Số điện thoại này đã được sử dụng.',
 
             'address.min' => 'Địa chỉ phải có ít nhất 5 ký tự.',
             'address.string' => 'địa chỉ phải là chuỗi ký tự hợp lệ.',
             'address.max' => 'địa chỉ không được vượt quá 255 ký tự.',
             'address.regex' => 'Không được nhập khoảng trắng.',
             'birth.date_format' => 'Giá trị của trường này phải là một ngày tháng năm và ở định dạng "Y-m-d" (ví dụ: "2023-08-15")',
 
             'image.image' => 'Ảnh này phải là một tệp hình ảnh (ảnh).',
             'image.mimes' => 'Chỉ chấp nhận định dạng: jpeg, png, jpg, gif, webp.',
             'image.max' => ' Kích thước tệp hình ảnh không được vượt quá 2MB..',
 
             'description.string' => 'Ghi chú của trường này phải là một chuỗi ký tự',
 
             'email.required' => 'Email là trường bắt buộc.',
             'email.email' => 'Địa chỉ email không hợp lệ.',
             'email.regex' => 'Email phải bắt đầu bằng chữ cái và có định dạng hợp lệ (vd: example@gmail.com).',
             'email.min' => 'Email phải có ít nhất 5 ký tự.',
             'email.max' => 'Email không được vượt quá 255 ký tự.',
             'email.unique' => 'Email đã tồn tại, vui lòng chọn email khác.',
 
             'new_password.required' => 'Mật khẩu là bắt buộc.',
             'new_password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
             'new_password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
             'new_password.regex' => 'Mật khẩu phải đáp ứng các yêu cầu sau: 
             - Ít nhất một chữ cái viết hoa (A-Z). 
             - Ít nhất một chữ cái viết thường (a-z). 
             - Ít nhất một chữ số (0-9). 
             - Ít nhất một ký tự đặc biệt (@, $, !, %, *, ?, &, #).',
         ];
     }
}
