<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FolderController extends Controller
{
    private Room $room;
    private Upload $upload;
    public function __construct()
    {
        $this->room = new Room();
        $this->upload = new Upload();
    }
    public function index()
    {
        $rooms = $this->room->with('uploads')->get();
        return Inertia::render('folder/index', ['rooms' => $rooms]);
    }
    public function download_file($id)
    {
        $room = $this->room->find($id);
        if ($room) {
            $all_files = Storage::allFiles($room->folder);
            $folder_name = strtoupper(str_replace("", "_", $room->folder)) . ".zip";
            foreach ($all_files as $file) {
                $zip = new \ZipArchive();
                if ($zip->open(storage_path('app/' . $folder_name), \ZipArchive::CREATE)) {
                    $zip->addFile(storage_path('app/' . $file), $file);
                    $zip->close();
                }
            }
        }
        return Response::download(storage_path('app/' . $folder_name), $folder_name, ['Content-Type: application/zip']);
    }
    public function detail(Request $request, $room)
    {
        $keyword = $request->keyword;
        if ($keyword != null) {
            $uploads = $this->upload->where('room_id', $room)->where('name', "LIKE", "%" . $keyword . "%")->orWhere('nim', "LIKE", "%" . $keyword . "%")->paginate(5);
        } else {
            $uploads = $this->upload->where('room_id', $room)->with('room')->paginate(5);
        }
        $roomName = $this->room->select('name', 'id')->find($room);
        if ($room) {
            return Inertia::render('folder/detail', ['uploads' => $uploads, 'roomName' => $roomName]);
        }
    }
}
