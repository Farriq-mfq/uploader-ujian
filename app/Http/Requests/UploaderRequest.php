<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploaderRequest extends FormRequest
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
            'nim' => 'required',
            'files' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name' => "Nama harus di isi",
            'nim' => "NIM Harus di isi",
            'files' => "File harus ada"
        ];
    }
}
