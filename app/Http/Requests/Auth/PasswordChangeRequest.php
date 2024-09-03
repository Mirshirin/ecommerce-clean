<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'name is required.',
    //         'email.required' => 'email is required.',
    //         'password.required' => 'password is required.',
           
    //     ];
    // }
}
