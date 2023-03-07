<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploaderRequest;
use App\Models\AllowIp;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UploaderController extends Controller
{
    private Room $room;
    private AllowIp $allowIP;
    public function __construct()
    {
        $this->room = new Room();
        $this->allowIP = new AllowIp();
    }
    public function index()
    {
        // get room by ip private
        $ip = gethostbyname(gethostname());
        $allowRoom = $this->allowIP->where('ip', $ip)->with('room')->get();
        // get room global ip
        $rooms = $this->room->doesnthave('allowsIP')->get();
        return Inertia::render('uploader/index', ['allows' => $allowRoom, 'globals' => $rooms]);
    }
    public function show_uploader($room)
    {
        $room = $this->room->where('name', $room)->where('status', 1)->first();
        return Inertia::render('uploader/show', ['room' => $room]);
    }

    public function upload(Request $request)
    {       
        dd($request->files->count());
    }
}
