<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; 
class UpdateUserRequest extends FormRequest
{
    protected $user; // Define a property to hold the user instance

    /**
     * Instantiate a new request instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Assuming you want to use the authenticated user
        $this->user = Auth::user(); // Get the authenticated user
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required',
            'phone' => 'string','max:255',
            'address' => ['string','max:255'],
           
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required.',
            'email.required' => 'email is required.',
            'password.required' => 'password is required.',
           
        ];
    }
}
