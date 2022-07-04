<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            //
            'txtAccount'=>'required',
            'txtPassword'=>'required|min:1',
        ];
    }
    public function messages(){
        return [
            'txtAccount.required'=>'Name is required',
            'txtPassword.required'=>'Password is required'
        ];
    }
}
