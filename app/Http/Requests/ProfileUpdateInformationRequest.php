<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
           // 'label' => ['string', 'max:255',Rule::unique(Permission::class)->ignore($this->user()->id)],
           // 'name' => ['required','string', 'max:255',Rule::unique(Permission::class)->ignore($this->user()->id)],
           'name' => [ 'string', 'max:255'],
            'email' => [ 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],

        ];
    }
}
