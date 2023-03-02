<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UploaderController extends Controller
{
    private Room $room;
    public function __construct()
    {
        $this->room = new Room();
    }
    public function index($room)
    {
        $room = $this->room->where('name', $room)->where('status', 1)->first();
        return Inertia::render('uploader/index', ['room' => $room]);
    }

    public function upload(Request $request)
    {
        dd($request->file);
    }
}
