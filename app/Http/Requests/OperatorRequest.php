<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class OperatorRequest extends FormRequest
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
        $room = User::find(request('operator'));
        return [
            'name' => 'required',
            'username' => [
                'required',
                'unique:users,username,' . request('operator'),
                'min:5',
                'regex:/^\S*$/u'
            ],
            'password' => [
                $room != null ? 'nullable' : 'required',
                'min:5'
            ],
            'confirm' => [
                $room != null ? 'nullable' : 'required',
                'same:password',
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => "Nama Harus di isi",
            'username.required' => "Username Harus di isi",
            'username.unique' => "Username sudah ada",
            'username.min' => "Username minimal 5 karakter",
            'username.regex' => "Username tidak boleh pakai space",
            'password.required' => "Password harus di isi",
            'password.min' => "Password minimal 5 karakter",
            'confirm.required' => "konfirmasi password harus di isi",
            'confirm.same' => "konfirmasi password harus sama dengan password",


        ];
    }
}
