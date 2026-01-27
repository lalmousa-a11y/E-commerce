<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStatusRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->user_type === 'admin';
    }

    public function rules()
    {
        return [
            'status' => 'required|in:pending,approved,rejected',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => ' status field is required',
            'status.in' => ' status must be one of: pending, approved, rejected',
        ];
    }

    public function attributes()
    {
        return [
            'status' => 'Product Status',
        ];
    }
}