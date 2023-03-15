<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    private Room $room;
    private User $user;
    public function __construct()
    {
        $this->room = new Room();
        $this->user = new User();
    }
    public function index()
    {
        if (Auth::user()->role === "operator") {
            $rooms = $this->room->where('operator_id', Auth::user()->id)->count();
        } else if (Auth::user()->role === "master") {
            $operators = $this->user->where('role', 'operator')->count();
            $rooms = $this->room->count();
        }
        return Inertia::render('index', ['rooms' => $rooms, 'operators' => $operators]);
    }
}
