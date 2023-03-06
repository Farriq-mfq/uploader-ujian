<?php

namespace App\Rules;

use App\Models\Room;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class FolderRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!request('room')) {
            if (Storage::directoryExists($value)) {
                $fail("Folder Sudah Tersedia Silahkan Buat Folder Lain");
            }
        } else {
            $id = request('room');
            $room = Room::find($id);
            if ($room->folder != $value) {
                if (Storage::directoryExists($value)) {
                    $fail("Folder Sudah Tersedia Silahkan Buat Folder Lain");
                }
            }
        }
    }
}
