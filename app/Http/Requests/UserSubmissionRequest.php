<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSubmissionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:user_submissions|max:255',
            'name' => 'required|max:255',
            'id_card' => 'required|max:50',
            'address' => 'required|max:255',
            'phone' => 'required|max:50',
            'self_employee_as' => 'max:255',
            'instalment_amount_data' => 'nullable|numeric|min:1',
            'avg_monthly_turnover_data' => 'nullable|numeric|min:1',
            'join_husband_data' => 'nullable|numeric|min:1',
            'join_wife_data' => 'nullable|numeric|min:1'
        ];
    }
}
