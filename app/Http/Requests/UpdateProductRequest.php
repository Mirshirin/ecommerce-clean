<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;


class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();//&& auth()->user()->isStaffUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $productId=$this->route('product');
        return [
            'title' => ['required','string','max:255',Rule::unique('products','title')->ignore($productId)],
            'description' => ['required','string','max:255'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation rules
            'discount_price' => ['nullable', 'numeric'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
    protected $messages = [
        'title.required' => 'Title is required.',
        'title.unique' => 'Title must be unique.',
        'image.mimes' => 'Only png, jpg, jpeg images are allowed.',
        'description.required' => 'Description is required.',
        'price.required' => 'Price is required.',
        'category_id' => 'category is required.',
        'quantity.min' => 'Quantity must be at least 1.',

    ];
    
}
