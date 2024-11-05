<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'nameCreate' => ['required', 'string', 'max:255'],
            'phoneCreate' => ['required', 'regex:/^(\+84|0[3|5|7|8|9])+([0-9]{8})$/'],
            'addressCreate' => ['required', 'string','max:255'], 
            'emailCreate' => ['required', 'email','max:255','unique:customers,email'],
            'ageCreate' => ['required', 'numeric', 'min:0', 'max:150'],
            'weightCreate' => ['required', 'numeric', 'min:0', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
            'nameCreate.required' => 'Trường tên là bắt buộc.',
            'nameCreate.string' => 'Tên phải là một chuỗi ký tự.',
            'nameCreate.max' => 'Tên không được vượt quá 255 ký tự.',

            'phoneCreate.required' => 'Trường số điện thoại là bắt buộc.',
            'phoneCreate.regex' => 'Số điện thoại không đúng định dạng.',

            'addressCreate.required' => 'Trường địa chỉ là bắt buộc.',
            'addressCreate.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'addressCreate.string' => 'Địa chỉ phải là một chuỗi ký tự.',

            'emailCreate.required' => 'Trường email là bắt buộc.',
            'emailCreate.email' => 'Trường email không đúng đinh dạng.',
            'emailCreate.max' => 'Email không được vượt quá 255 ký tự.',
            'emailCreate.unique' => 'Email đã tồn tại.',

            'ageCreate.required' => 'Trường tuổi là bắt buộc.',
            'ageCreate.integer' => 'Tuổi phải là một số nguyên.',
            'ageCreate.max' => 'Tuổi không được vượt quá 150 tuổi.',
            'ageCreate.min' => 'Tuổi phải là số lớn hơn hoặc bằng 1.',
            'ageCreate.numeric' => 'Tuổi phải là một số.',

            'weightCreate.required' => 'Trường cân nặng là bắt buộc.',
            'weightCreate.numeric' => 'Cân nặng phải là một số.',
            'weightCreate.max' => 'Cân nặng không được vượt quá 200kg.',
            'weightCreate.min' => 'Cân nặng là số lớn hơn hoặc bằng 1.',
            'weightCreate.integer' => 'Cân nặng phải là một số nguyên.',
        ];
    }
}
