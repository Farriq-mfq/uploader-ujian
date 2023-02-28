<?php

namespace App\Http\Requests;

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
            'name' => "required|unique:rooms,name",
            'TimeRanges'=>['required',new timeRanges()],
            'IpStart'=>'required|ip',
            'IpEnd'=>[
                'required',
                'ip',
                new IpRanges($this->IpStart)
            ],
            'folder'=>'required|regex:/^\S*/',
            'extensions'=>'required|regex:/\.\w+/',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => "Nama harus di isi",
            'TimeRanges.required'=>"Waktu harus di isi dengan benar",
            'IpStart.required'=>"IP range harus di isi",
            'IpStart.ip'=>"IP tidak valid",
            'IpEnd.required'=>"IP range harus di isi",
            'IpEnd.ip'=>"IP tidak valid",
            'folder.required'=>"nama folder harus di isi",
            "extensions.required"=>"Extension yang di izinkan harus di isi",
            'name.unique'=>"nama sudah di gunakan",
            'extensions.regex'=>"extensions tidak valid"
        ];
    }
}
