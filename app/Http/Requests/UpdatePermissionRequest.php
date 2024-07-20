<?php

namespace App\Http\Requests;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
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

    public function rules(Request $request)
    {
        return [
           
            'name' => ['required','string','max:255',Rule::unique(Permission::class)->ignore($request->id)],
            'guard_name' => ['nullable','string','max:255',Rule::unique(Permission::class)->ignore($request->id)],

            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required.',
            'guard_name.required' => 'guard_name is required.',
           
        ];
    }
}
