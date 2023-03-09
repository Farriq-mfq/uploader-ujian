<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Rules\NimRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploaderRequest extends FormRequest
{
    private Room $room;
    public function __construct()
    {
        $this->room = new Room();
    }
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
        $room = $this->room->where('name', request('room'))->first();
        $extensions = explode(",", str_replace(".", "", $room->extensions));
        return [
            'name' => 'required',
            'nim' => [
                'required',
                'regex:/\d{2}+\.\d{3}+\.\d{4}+/',
                new NimRule()
            ],
            'type' => $room->type_field ? 'required|max:1|min:1' : '',
            'files.*' => [
                'required',
                'file',
                "mimes:" . $room->extensions
            ]
        ];
    }
    public function messages(): array
    {
        $room = $this->room->where('name', request('room'))->first();
        return [
            'name.required' => "Nama harus di isi",
            'nim.required' => "NIM Harus di isi",
            'files.*.required' => "File harus ada",
            'files.*.mimes' => "extensions yang diizinkan hanya : " . $room->extensions,
            'type.required' => "Type soal harus di isi",
            'nim.regex' => "Format NIM tidak valid"

        ];
    }
}
