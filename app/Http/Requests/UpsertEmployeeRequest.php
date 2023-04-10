<?php

namespace App\Http\Requests;

use App\Enum\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpsertEmployeeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required',
            'email' => 'required|email|unique:employees',
            'department_id' => 'required',
            'job_title' => 'required',
            'payment_type' => ['required', new Enum(Payment::class)],
            'salary' => [
                Rule::requiredIf($this->input('payment_type') == Payment::SALARY),
                'numeric', 'gt:0'],
            'hourly_rate' => [
                Rule::requiredIf($this->input('payment_type') == Payment::HOURLY_RATE),
                'numeric', 'gt:0'],
        ];
    }
}
