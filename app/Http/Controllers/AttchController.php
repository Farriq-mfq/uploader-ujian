<?php

namespace App\Http\Controllers;

use App\Models\AttchRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttchController extends Controller
{
    private AttchRoom $attch;
    public function __construct()
    {
        $this->attch = new AttchRoom();
    }

    public function removeAttch($attch)
    {
        $find = $this->attch->with('room')->find($attch);
        Storage::delete('attch/' . $find->room->name . "/" . $find->file);
        $this->attch->where('id', $attch)->delete();
    }
}
