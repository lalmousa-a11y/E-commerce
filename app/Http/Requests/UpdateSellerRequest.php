<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerRequest extends FormRequest
{
 
    public function authorize()
    {
        return auth()->check() && auth()->user()->user_type === 'admin';
    }

 
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('seller')->id,
            'is_approved' => 'required|boolean',
        ];
    }

   
    public function messages()
    {
        return [
            'name.required' => ' name is required',
            'name.max' => 'name must not exceed 255 characters',
            'email.required' => 'email is required',
            'email.email' => 'email is invalid',
            'email.unique' => 'email is already in use',
            'is_approved.required' => 'approval status is required',
            'is_approved.boolean' => 'approval status is invalid',
        ];
    }
}