<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'tax_code' => ['nullable', 'max:13'],
            'name' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[^\d]*$/'],
           'phone' => [
                'required',
                'regex:/^(0(2\d{8,9}|3\d{8}|5\d{8}|7\d{8}|8\d{8}|9\d{8}))$/',
                'numeric',
                Rule::unique('suppliers', 'phone')->whereNull('deleted_at'),
            ],
            'address' => ['required', 'string', 'max:255', 'min:5', 'regex:/.*([a-zA-Z].*){3,}/'],
           'email' => [
                'required',
                'email',
                'regex:/^[a-z][a-z0-9._%+-]*@[a-z0-9.-]+\.[a-z]{2,}$/',
                'min:5',
                'max:255',
                Rule::unique('suppliers', 'email')->whereNull('deleted_at'),
            ],
        ];
    }
    
    public function messages()
    {
        return [
            'tax_code.max' => 'Quá số lượng ký tự.',
    
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'name.regex' => 'Tên không được nhập số.',
            'name.min' => 'Tên phải lớn hơn hoặc bằng 3 ký tự.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập số bắt đầu bằng 0 và có 10 chữ số. định dạng Sô điện thoại VN',
            'phone.numeric' => 'Số điện thoại phải là một chuỗi số hợp lệ.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
    
            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'address.min' => 'Địa chỉ phải lớn hơn hoặc bằng 5 ký tự.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.regex' => 'Địa chỉ phải chứa ít nhất 3 chữ cái.',
    
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'email.min' => 'Email phải có ít nhất 5 ký tự.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.regex' => 'Email phải bắt đầu bằng chữ cái, không chứa ký tự viết hoa và tuân theo định dạng hợp lệ (ví dụ: example@gmail.com).',
            'email.unique' => 'Email đã tồn tại. Vui lòng sử dụng một email khác.',
        ];
    }
    
}
