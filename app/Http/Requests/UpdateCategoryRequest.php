<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; 
class UpdateCategoryRequest extends FormRequest
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
    }

    public function authorize()
    {
        return auth()->check();//&& auth()->user()->isStaffUser();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string']           
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'name is required.', 
        ];
    }
}
