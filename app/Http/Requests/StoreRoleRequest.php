<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; 
class StoreRoleRequest extends FormRequest
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
        return auth()->check();//&& auth()->user()->isStaffUser();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:250|unique:roles,name',
            'permissions' => 'required',

            
        ];
    }

    
}
