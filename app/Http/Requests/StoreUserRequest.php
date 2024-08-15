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
            'phone' => 'required|string|max:10',
            'address' => 'required|string',
            'birth' => 'required|date_format:Y-m-d',
            'image' => 'required|image|max:2048',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',

            'type' => ['required', 'in:' . User::TYPE_ADMIN . ',' . User::TYPE_STAFF],
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'birth' => 'Birth Date',
            'image' => 'Image',
            'description' => 'Description',
            'email' => 'Email',
            'password' => 'Password',
            'type' => ' Type',
        ];
    }
}
