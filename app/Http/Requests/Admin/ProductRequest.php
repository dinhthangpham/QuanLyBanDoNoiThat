<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name_product'=>'required',
            'category_product'=>'required',
            'img_product'=>'required',
            'category_product'=>'required',
                
        ];
    }
    public function messages(){
        return [
            'name_product.required'=>'Name product is required',
            'category_product.required'=>'Category for product is required',
            'img_product.required'=>'Image for product is required',
           
            'category_product.required'=>'Category is required',
        ];
    }
}
