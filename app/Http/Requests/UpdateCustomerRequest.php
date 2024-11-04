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
            'nameEdit' => ['required', 'string', 'max:255'],
            'phoneEdit' => ['required', 'regex:/^(\+84|0[3|5|7|8|9])+([0-9]{8})$/'],
            'addressEdit' => ['required', 'string','max:255'], 
            'emailEdit' => ['required', 'email','max:255'],
            'ageEdit' => ['required', 'numeric', 'min:0', 'max:150'],
            'weightEdit' => ['required', 'numeric', 'min:0', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
           'nameEdit.required' => 'Trường tên là bắt buộc.',
            'nameEdit.string' => 'Tên phải là một chuỗi ký tự.',
            'nameEdit.max' => 'Tên không được vượt quá 255 ký tự.',

            'phoneEdit.required' => 'Trường số điện thoại là bắt buộc.',
            'phoneEdit.regex' => 'Số điện thoại không đúng định dạng.',

            'addressEdit.required' => 'Trường địa chỉ là bắt buộc.',
            'addressEdit.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'addressEdit.string' => 'Địa chỉ phải là một chuỗi ký tự.',

            'emailEdit.required' => 'Trường email là bắt buộc.',
            'emailEdit.email' => 'Trường email không đúng đinh dạng.',
            'emailEdit.max' => 'email không được vượt quá 255 ký tự.',
            
            'ageEdit.required' => 'Trường tuổi là bắt buộc.',
            'ageEdit.integer' => 'Tuổi phải là một số nguyên.',
            'ageEdit.max' => 'Tuổi không được vượt quá 150 tuổi.',
            'ageEdit.min' => 'Tuổi phải là số lớn hơn hoặc bằng 1.',
            'ageEdit.numeric' => 'Tuổi phải là một số.',

            'weightEdit.required' => 'Trường cân nặng là bắt buộc.',
            'weightEdit.numeric' => 'Cân nặng phải là một số.',
            'weightEdit.max' => 'Cân nặng không được vượt quá 200kg.',
            'weightEdit.min' => 'Cân nặng là số lớn hơn hoặc bằng 1.',
            'weightEdit.integer' => 'Cân nặng phải là một số nguyên.',
        ];
    }
}
