<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^(\+84|0[3|5|7|8|9])+([0-9]{8})$/'],
            'address' => ['required', 'string','max:255'], 
            'email' => ['required', 'email','max:255'],
            'age' => ['required', 'numeric', 'min:0', 'max:150'],
            'weight' => ['required', 'numeric', 'min:0', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
           'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',

            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',

            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Trường email không đúng đinh dạng.',
            'email.max' => 'email không được vượt quá 255 ký tự.',

            'age.required' => 'Trường tuổi là bắt buộc.',
            'age.integer' => 'Tuổi phải là một số nguyên.',
            'age.max' => 'Tuổi không được vượt quá 150 tuổi.',
            'age.min' => 'Tuổi phải là số lớn hơn hoặc bằng 1.',
            'age.numeric' => 'Tuổi phải là một số.',

            'weight.required' => 'Trường cân nặng là bắt buộc.',
            'weight.numeric' => 'Cân nặng phải là một số.',
            'weight.max' => 'Cân nặng không được vượt quá 200kg.',
            'weight.min' => 'Cân nặng là số lớn hơn hoặc bằng 1.',
            'weight.integer' => 'Cân nặng phải là một số nguyên.',
        ];
    }
}
