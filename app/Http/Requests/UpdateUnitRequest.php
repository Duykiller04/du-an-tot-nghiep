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

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units')->ignore($this->unit->id)
                ],

            'parent_id' => 'nullable|exists:units,id|not_in:' . $this->unit->id,
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên đơn vị là bắt buộc.',
            'name.unique' => 'Tên đơn vị đã tồn tại.',
            'name.max' => 'Tên đơn vị không được vượt quá 255 ký tự.',
           'parent_id.exists' => 'Đơn vị cha không hợp lệ.',
            'parent_id.not_in' => 'Đơn vị cha không thể là chính nó.',
        ];
    }
}
