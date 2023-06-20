<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'webSite' => ['required', 'string', 'max:400'],
            'sex' => ['required', 'in:male,female'],
//            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
