<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'category_id' => 'required',
            'product_name' => 'required',
            'buying_date' => 'required',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ];
    }
}
