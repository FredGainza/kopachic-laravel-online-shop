<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'holder' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'bic' => 'required|regex:/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i',
            'iban' => 'required|regex:^[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}^',
            'bank' => 'required|string|max:255',
            'bank_address' => 'required|string|max:255',
            'phone' => 'required|string|max:25',
            'facebook' => 'required|url|max:255',
            'home' => 'required|string|max:255',
            'home_infos' => 'nullable|string',
            'home_shipping' => 'nullable|string',
        ];
    }
}
