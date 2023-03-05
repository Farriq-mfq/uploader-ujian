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
        $find = $this->attch->where('id', $attch)->select('file')->first();
        $delete = $this->attch->where('id', $attch)->delete();
        if ($delete) {
            Storage::delete('attch/' . $find->file);
        }
    }
}
