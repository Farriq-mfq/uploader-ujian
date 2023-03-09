<?php

namespace App\Rules;

use App\Models\Room;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NimRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $room = Room::where('name', request('room'))->whereHas('uploads', function ($q) use ($value) {
            return $q->where('nim', $value);
        })->first();
        if ($room) {
            $fail("NIM ini sudah pernah upload");
        }
    }
}
