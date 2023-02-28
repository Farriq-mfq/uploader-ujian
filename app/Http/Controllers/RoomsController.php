<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomsRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class RoomsController extends Controller
{

    private Room $room;
    public function __construct()
    {
        $this->room = new Room();
    }

    /**
     * Display a listing of the resource.
     * @param Illuminate\Http\Request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        if ($request->keyword) {
            $rooms = $this->room->where("name", "LIKE", "%" . $request->keyword . "%")->latest()->get();
        } else {
            $rooms = $this->room->latest()->get();
        }
        return Inertia::render('rooms/index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $url = URL::to("/");
        return Inertia::render('rooms/create', ['baseUrl' => $url]);
    }

    /**
     * Store a newly created resource in storage.
     * @param App\Http\Requests\RoomsRequest
     */
    public function store(RoomsRequest $request)
    {
        $times = $request->TimeRanges;
        $data = [
            "name" => $request->name,
            "time_start" => $times[0],
            "time_end" => $times[1],
            "ip_start" => $request->IpStart,
            "ip_end" => $request->IpEnd,
            "folder" => $request->folder,
            "status" => $request->status,
            "extensions" => $request->extensions,
        ];
        $this->room->create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function batch_remove()
    {
        $all = $this->room->select('id')->get();
        $this->room->whereIn('id', $all)->delete();
    }
}
