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
            $rooms = $this->room->where("name", "LIKE", "%" . $request->keyword . "%")->latest()->paginate(5);
        } else {
            $rooms = $this->room->latest()->paginate(5);
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
            "folder" => $request->folder,
            'kelas' => $request->kelas,
            'mata_kuliah' => $request->mata_kuliah,
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
        $room = $this->room->find($id);
        return Inertia::render('rooms/edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomsRequest $request, string $id)
    {
        $times = $request->TimeRanges;
        $data = [
            "name" => $request->name,
            "time_start" => $times[0],
            "time_end" => $times[1],
            'kelas' => $request->kelas,
            'mata_kuliah' => $request->mata_kuliah,
            "folder" => $request->folder,
            "status" => $request->status,
            "extensions" => $request->extensions,
        ];
        $this->room->where('id', $id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->room->where('id', $id)->delete();
    }


    /**
     * remove all rooms
     */
    public function batch_remove()
    {
        $this->room->where('id', ">", 0)->delete();
    }

    /**
     * update active record
     */

    public function batch_active()
    {
        $this->room->where('id', ">", 0)->update(['status' => true]);
    }
    /**
     * update inactive record
     */

    public function batch_inactive()
    {
        $this->room->where('id', ">", 0)->update(['status' => false]);
    }

    /**
     * @param string $id
     */
    public function active($id)
    {
        $room = $this->room->select('status')->find($id);
        if ($room != null) {
            $this->room->active($room->status, $id);
        }
    }
    public function attch(Request $request)
    {
        dd($request->files);
    }
}
