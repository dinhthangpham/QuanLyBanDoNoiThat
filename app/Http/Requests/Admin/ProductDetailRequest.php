<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductDetailRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'image_detail'=>'required',
            'colorProduct'=>'required',
        ];
        
    }
    public function messages()
    {
        return [
            'image_detail.required'=>'Image detail is required',
            'colorProduct.required'=>'Color is required',
        ];
    }
}
