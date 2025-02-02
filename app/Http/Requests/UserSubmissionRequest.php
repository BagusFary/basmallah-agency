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
            'id_card' => 'required|unique:user_submissions|max:50',
            'address' => 'required|max:255',
            'phone' => 'required|unique:user_submissions|max:50',
            'self_employee_as' => 'max:255',
            'instalment_amount' => 'nullable|numeric|min:1',
            'avg_monthly_turnover' => 'nullable|numeric|min:1',
            'join_husband' => 'nullable|numeric|min:1',
            'join_wife' => 'nullable|numeric|min:1',
            'self_income' => 'nullable|numeric|min:1'
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
