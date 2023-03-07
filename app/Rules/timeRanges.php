<?php

namespace App\Rules;

use App\Models\Room;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class timeRanges implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!request('room')) {
            if ($value[1] == null) {
                $fail("waktu habis harus di isi");
            } else if (strtotime($value[0]) < strtotime(date("Y-m-d H:i:s"))) {
                $fail("Waktu harus lebih dari waktu sekarang");
            }
        } else {
            $id = request('room');
            $room = Room::find($id);
            $start = $room->time_start;
            $end = $room->time_end;
            if ($start != $value[0] || $end != $value[1]) {
                if ($value[1] == null) {
                    $fail("waktu habis harus di isi");
                } else if (strtotime($value[0]) < strtotime(date("Y-m-d H:i:s"))) {
                    $fail("Waktu harus lebih dari waktu sekarang");
                }
            }
        }
    }
}
