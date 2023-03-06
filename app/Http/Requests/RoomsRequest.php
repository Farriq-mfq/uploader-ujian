<?php

namespace App\Http\Requests;

use App\Rules\FolderRule;
use App\Rules\IpRanges;
use App\Rules\timeRanges;
use Illuminate\Foundation\Http\FormRequest;

class RoomsRequest extends FormRequest
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
            'name' => "required|unique:rooms,name," . $this->segment(2),
            'TimeRanges' => ['required', new timeRanges()],
            "ip.*" => "required|ip",
            'folder' => [
                'required',
                new FolderRule()
            ],
            'kelas' => 'required',
            'mata_kuliah' => 'required',
            'extensions' => 'required|regex:/\.(\w)+/',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => "Nama harus di isi",
            'TimeRanges.required' => "Waktu harus di isi dengan benar",
            'folder.required' => "nama folder harus di isi",
            "extensions.required" => "Extension yang di izinkan harus di isi",
            'name.unique' => "nama sudah di gunakan",
            'kelas.required' => "Kelas harus di isi",
            'mata_kuliah.required' => "Mata Kuliah harus di isi",
            'extensions.regex' => "extensions tidak valid"
        ];
    }
}
