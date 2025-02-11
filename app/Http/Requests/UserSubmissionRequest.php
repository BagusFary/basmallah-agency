<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
            'id_card' => 'required|unique:user_submissions|max:50',
            'address' => 'required|max:255',
            'phone' => 'required|unique:user_submissions|max:50',
            'employment_status' => 'required|in:self_employees,civil_servants,employees',
            'self_employee_as' => 'max:255',
            'has_instalment' => 'required|in:1,0',
            'instalment_amount' => [
                'numeric',
                Rule::when($this->has_instalment == 1, ['min:1', 'max:99999999999']), 
            ],    
            'avg_monthly_turnover' => [
                'numeric',
                Rule::when($this->employment_status == 'self_employees', ['min:1','max:99999999999'])
            ],
            'join_husband' => [
                'numeric',
                Rule::when($this->salary == 'joint_income', ['min:1', 'max:99999999999'])
            ],
            'join_wife' => [
                'numeric',
                Rule::when($this->salary == 'joint_income', ['min:1', 'max:99999999999'])
            ],
            'self_income' => [
                'numeric',
                Rule::when($this->salary == 'personal_income', ['min:1', 'max:99999999999'])
            ]
        ];
    }

    public function attributes(): array 
    {
        return [
            'email' => 'Email',
            'name' => 'Nama',
            'id_card' => 'NIK',
            'address' => 'Alamat',
            'phone' => 'Nomor WhatsApp',
            'self_employee_as' => 'Bidang Wirausaha',
            'instalment_amount' => 'Jumlah Cicilan',
            'avg_monthly_turnover' => 'Omset Perbulan',
            'join_husband' => 'Penghasilan Suami',
            'join_wife' => 'Penghasilan Istri',
            'self_income' => 'Penghasilan Pribadi',
        ];
    }
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi!',
            'email' => 'Format :attribute tidak valid',
            'unique' => ':attribute sudah ada',
            'max' => ':attribute tidak boleh melebihi Rp.:max',
            'min' => ':attribute minimal Rp.:min',
            'numeric' => ":attribute wajib berupa angka/nominal"
        ];
    }
}
