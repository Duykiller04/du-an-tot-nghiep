<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'nameEdit' => 'required|string|max:255',
            'parent_idEdit' => 'nullable|integer',
            'is_activeEdit' => 'nullable|boolean',
        ];
    }
    
    public function messages()
    {
        return [
            'nameEdit.required' => 'Trường tên là bắt buộc.',
            'nameEdit.string' => 'Trường tên phải là chuỗi.',
            'nameEdit.max' => 'Trường tên không được vượt quá 255 ký tự.',
            'parent_idEdit.integer' => 'Parent ID phải là một số nguyên.',
            'is_activeEdit.boolean' => 'Giá trị cho Is Active phải là true hoặc false.',
        ];
    }
    
}
