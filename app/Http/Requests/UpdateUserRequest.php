<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId= $this->route('user')->id;
        return [
            'name' => 'required|string|max:250',
            //'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,'.$this->user->id,
            'email' => ['required','email','max:250',Rule::unique('users')->ignore($userId)],
            'phone' => 'required',
            'address' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required'
        ];

    }
     public function message()  {
        return [
            'email.unique' => 'this email is repeated!!!!'
        ];
     }
}