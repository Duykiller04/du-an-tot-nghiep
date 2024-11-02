<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUnitRequest extends FormRequest
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

            'nameEdit' => [
                'required',
                'string',
                'max:255',   
                ],
        ];
    }
    public function messages()
    {
        return [
            'nameEdit.required' => 'Tên đơn vị là bắt buộc.',
            'nameEdit.unique' => 'Tên đơn vị đã tồn tại.',
            'nameEdit.max' => 'Tên đơn vị không được vượt quá 255 ký tự.',
        ];
    }
}
