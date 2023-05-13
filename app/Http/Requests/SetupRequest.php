<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetupRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'konfirmasi_password' => 'required|same:password'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Nama Harus diisi",
            'username.required' => "Username Harus diisi",
            'password.required' => "Password Harus diisi",
            'konfirmasi_password.required' => "Konfirmasi Password Harus diisi",
            'konfirmasi_password.same' => "Konfirmasi Password Harus Sama dengan Password",
        ];
    }
}
