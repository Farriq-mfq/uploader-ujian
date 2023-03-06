<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FolderController extends Controller
{
    private Room $room;
    public function __construct()
    {
        $this->room = new Room();
    }
    public function index()
    {
        $rooms = $this->room->all();
        return Inertia::render('folder/index', ['rooms' => $rooms]);
    }
}
